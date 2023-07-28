<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('active_link')) {
    function active_link (string $route, string $class = 'active') : string {
        return Route::is($route) ? $class : '';
    }
}


function buildTree($arr, $pid = null, $withParents = true) : array {
    $tree = [];
    foreach($arr as $item) {
        if($item['include_in'] == $pid) {

            $tree[$item['id']] = [
                'id'         => $item['id'],
                'title'      => $item['title'],
                'weight'     => $item['weight'],
                'include_in' => $item['include_in'],
                'active'     => $item['active'],
            ];

            $children = buildTree( $arr, $item['id']);

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
