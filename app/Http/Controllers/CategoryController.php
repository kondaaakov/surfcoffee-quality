<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        $catsArr = buildTree($categories->toArray());

        return view('categories.index', ['categories' => $catsArr]);
    }

    public function create() : View {
        $categories = Category::query()->where("active", "=", 1)->get();
        $categoriesArr = [];

        foreach ($categories as $category) {
            $categoriesArr[$category->id] = "$category->title // $category->weight";
        }

        $alternateTitle = '';

        if (isset($_GET['include_in'])) {
            $titleOfParentCategory = DB::table('categories')->where('id', $_GET['include_in'])->value('title');
            if (empty($titleOfParentCategory)) {
                abort(404, 'Категории, к которой вы хотите добавить подкатегорию, не существует!');
            }

            $alternateTitle = "Добавление подкатегории к «{$titleOfParentCategory}»";
        }

        return view('categories.create', ['categories' => $categoriesArr, 'alternateTitle' => $alternateTitle]);
    }

    public function store(Request $request) : RedirectResponse {

        $validated = $request->validate([
            'title'      => ['required', 'string'],
            'weight'     => ['required', 'decimal:0,3'],
            'include_in' => ['integer'],
        ]);

        $category = Category::query()->create([
            'title'      => trim($validated['title']),
            'weight'     => $validated['weight'],
            'include_in' => $validated['include_in'],
        ]);

        return redirect()->route('categories')->withFragment($category->id);
    }

    public function show($id) {

    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        $categories = Category::query()->where("active", 1)->get();
        $categoriesArr = [];

        foreach ($categories as $cat) {
            $categoriesArr[$cat->id] = "$cat->title // $cat->weight";
        }

        return view('categories.edit', ['category' => $category, 'categories' => $categoriesArr]);
    }

    public function update(Request $request, $id) : RedirectResponse {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'title'      => ['required', 'string'],
            'weight'     => ['required', 'decimal:0,3'],
            'include_in' => ['integer'],
        ]);

        $category->fill($validated)->save();

        return redirect()->route('categories')->withFragment($id);
    }

    public function archive($id): RedirectResponse {
        $category      = Category::findOrFail($id);
        $categories    = Category::all();
        $categoriesIds = array_merge([$category->id], getIdsOfCildrens(buildTree($categories->toArray(), $id)));

        DB::table('categories')->whereIn('id', $categoriesIds)->update(['active' => 0]);

        return redirect()->route('categories')->withFragment($id);
    }

    public function unarchive($id): RedirectResponse {
        $category      = Category::findOrFail($id);
        $categories    = Category::all();
        $categoriesIds = array_merge([$category->id], getIdsOfCildrens(buildTree($categories->toArray(), $id, false)));

        DB::table('categories')->whereIn('id', $categoriesIds)->update(['active' => 1]);

        return redirect()->route('categories')->withFragment($id);
    }
}
