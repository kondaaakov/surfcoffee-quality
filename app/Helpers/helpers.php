<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

if (!function_exists('active_link')) {
    function active_link (string|array $route, string $class = 'active') : string {
        if(is_array($route)) {
            foreach ($route as $routeOne) {
                if (Route::is($routeOne)) {
                    return $class;
                }
            }
        } else {
            return Route::is($route) ? $class : '';
        }

        return '';
    }
}


function buildTree($arr, $pid = null, $withParents = true, $forPolls = false) : array {
    $tree = [];
    foreach($arr as $item) {
        if($item['include_in'] == $pid) {

            if ($forPolls) {
                $tree[$item['id']] = [
                    'id'         => $item['id'],
                    'title'      => $item['title'],
                    'weight'     => $item['weight'],
                    'rate'       => $item['rate'],
                    'result'     => $item['result'],
                    'include_in' => $item['include_in'],
                ];
            } else {
                $tree[$item['id']] = [
                    'id'         => $item['id'],
                    'title'      => $item['title'],
                    'weight'     => $item['weight'],
                    'include_in' => $item['include_in'],
                    'active'     => $item['active'],
                ];
            }


            $children = buildTree( $arr, $item['id'], $withParents, $forPolls);

            if ($children && $withParents) {
                foreach ($children as $id => $child) {
                    $child['parent'] = $tree[$item['id']];
                    if (isset($child['parent']['parent'])) unset($child['parent']['parent']);
                    if (isset($child['parent']['items'])) unset($child['parent']['items']);
                    $tree[$item['id']]['items'][$id] = $child;
                }
            } else if ($children && !$withParents) {
                $tree[$item['id']]['items'] = $children;
            }

        }
    }
    return $tree;
}

function buildTreePoll($categories, $plate = false) : array {
    $allCategories = DB::table('categories')->get()->toArray();
    $dbCategories = [];
    foreach ($allCategories as $category) {
        $dbCategories[$category->id] = [
            'id'         => $category->id,
            'title'      => $category->title,
            'weight'     => $category->weight,
            'include_in' => $category->include_in,
            'active'     => $category->active,
        ];
    }

    $pollCategoriesPlusDbCategories = [];

    foreach ($categories as $category) {
        $pollCategoriesPlusDbCategories[$category['category_id']] = [
            'id' => $category['category_id'],
            'title' => $dbCategories[$category['category_id']]['title'],
            'weight' => $category['weight'],
            'rate' => $category['rate'],
            'result' => $category['result'],
            'include_in' => $dbCategories[$category['category_id']]['include_in'],
            'active' => $dbCategories[$category['category_id']]['active']
        ];
    }

    $categories = addRatesTree($pollCategoriesPlusDbCategories);

    if ($plate) {
        return $categories;
    } else {
        return buildTree($categories, null, true, true);
    }

}

function addRatesTree($categories) {

    for ($i = 0; $i <= 2; $i++) {
        $includeIdsAndRates = getIncludesIds($categories);

        foreach ($includeIdsAndRates as $key => $rate) {
            $categories[$key]['rate'] = $rate;

            $result = $rate * $categories[$key]['weight'];
            $categories[$key]['result'] = 0.01 * (int) ( $result * 100 );
        }
    }

    return $categories;
}

function getIncludesIds($categories) : array {
    $includeIdsAndRates = [];

    foreach ($categories as $category) {
        if ($category['include_in'] > 0) {
            if (isset($includeIdsAndRates[$category['include_in']])) {
                $includeIdsAndRates[$category['include_in']] += (float)$category['result'];
            } else {
                $includeIdsAndRates[$category['include_in']] = (float)$category['result'];
            }
        }
    }

    return $includeIdsAndRates;
}

function getIdsOfCildrens($arr) : array {
    $kids = [];

    foreach ($arr as $kid) {
        $kids[] = $kid['id'];
        if (isset($kid['items'])) {
            $kids = array_merge($kids, getIdsOfCildrens($kid['items']));
        }
    }

    return $kids;
}


function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function coloredRate(float $rate, string $classes = '') : string {
    if ($rate == 0) {
        return "нет оценки";
    } else if ($rate >= 80) {
        return "<span class='text-success $classes'>$rate</span>";
    } else if ($rate >= 50) {
        return "<span class='text-warning $classes'>$rate</span>";
    } else {
        return "<span class='text-danger $classes'>$rate</span>";
    }
}
