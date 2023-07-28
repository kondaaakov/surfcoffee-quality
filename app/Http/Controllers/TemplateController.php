<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(Request $request) {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $limit = $validated['limit'] ?? 10;

        $templates = Template::query()
//            ->where([
//                ['external_id', '>', 210],
//                ['title', 'like', '%Dyb%']
//            ])
            ->oldest('id')
            ->paginate($limit, ['id', 'created_at', 'title', 'categories', 'active']);



        return view('templates.index', ['templates' => $templates,]);
    }

    public function create() {
        $categories = buildTree(Category::query()->where("active", 1)->get()->toArray());

        return view('templates.create', ['categories' => $categories]);

    }

    public function store(Request $request) {
        $categoriesFromDB = Category::query()->where("active", 1)->get()->toArray();
        $categories = [];
        foreach ($categoriesFromDB as $category) {
            $categories[$category['id']] = [
                'id'         => $category['id'],
                'title'      => $category['title'],
                'weight'     => $category['weight'],
                'include_in' => $category['include_in'],
                'active'     => $category['active'],
            ];
        }

        $requestToArray = $request->toArray();
        $categoriesInRequest = [];

        foreach ($requestToArray as $key => $item) {
            if (str_contains($key, 'cat')) {
                $categoryId = str_replace('cat_', '', $key);
                $categoriesInRequest[$categoryId] = $categories[$categoryId];
            }
        }

        $categoriesInRequest = buildTree($categoriesInRequest);

        $validated = $request->validate([
            'title' => ['required', 'string'],
        ]);

        $template = Template::query()->create([
            'title'      => trim($validated['title']),
            'categories' => serialize($categoriesInRequest),
        ]);

        return redirect()->route('templates')->withFragment($template->id);
    }

    public function show($id) {
        $template = Template::findOrFail($id);
        $categories = [];

        if (!empty($template->categories)) {
            $categories = unserialize($template->categories);
        }

        return view('templates.show', ['template' => $template, 'categories' => $categories]);
    }

    public function edit($id) {
        $template = Template::findOrFail($id);
        $categories = buildTree(Category::query()->where("active", 1)->get()->toArray());
        $categoriesInTemplate = getIdsOfCildrens(unserialize($template->categories));

        return view('templates.edit', ['template' => $template, 'categories' => $categories, 'categoriesInTemplate' => $categoriesInTemplate]);
    }

    public function update(Request $request, $id) {
        $template = Template::findOrFail($id);
        $categoriesFromDB = Category::query()->where("active", 1)->get()->toArray();
        $categories = [];
        foreach ($categoriesFromDB as $category) {
            $categories[$category['id']] = [
                'id'         => $category['id'],
                'title'      => $category['title'],
                'weight'     => $category['weight'],
                'include_in' => $category['include_in'],
                'active'     => $category['active'],
            ];
        }

        $requestToArray = $request->toArray();
        $categoriesInRequest = [];

        foreach ($requestToArray as $key => $item) {
            if (str_contains($key, 'cat')) {
                $categoryId = str_replace('cat_', '', $key);
                $categoriesInRequest[$categoryId] = $categories[$categoryId];
            }
        }

        $categoriesInRequest = buildTree($categoriesInRequest);

        $validated = $request->validate([
            'title' => ['required', 'string'],
        ]);

        $template->fill([
            'title'      => trim($validated['title']),
            'categories' => serialize($categoriesInRequest),
        ])->save();

        return redirect()->route('templates.show', $template->id);

    }

    public function delete($id) {

    }

    public function archive($id) {

    }

    public function unarchive($id) {

    }
}
