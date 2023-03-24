<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryForm;
use Illuminate\Http\Request;
use App\DataTables\admin\CategoriesDataTable;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('categories.index');

    }
    public function create()
    {

        $categories = Category::where('parent_id', null)
            ->get();

        return view('categories.create', compact('categories'));
    }
    public function store(CategoryForm $request)
    {

        $validatedInput = $request->validated();

        if ($request->has('image')) {
            $filePath = $request->file('image')
                ->store('storage/categories');
            $validatedInput['image'] = $filePath;
        }

        Category::create($validatedInput);

        return redirect()
            ->route('categories.index')
            ->with([
                'message' => ['تم اضافة القسم بنجاح', 'success']
            ]);
    }
    public function edit(Category $category)
    {

        $categories = Category::where('parent_id', null)->get();
        return view('categories.edit', compact('categories', 'category'));
    }
    public function update(CategoryForm $request, Category $category)
    {
        $validatedInput = $request->except('old_image');
        if ($request->has('image')) {
            $filePath = $request->file('image')
                ->store('storage/categories');
            $validatedInput['image'] = $filePath;
        }
        $category->update($validatedInput);

        return redirect()->route('categories.index')->with([
            'message' => ['تم اضافة القسم بنجاح', 'success']
        ]);
    }
    public function destroy(Category $category)
    {

        $category->subCategories()->delete();

        $category->products->each(function ($product) {
            $product->colors()->detach();
            $product->sizes()->detach();
        });

        $category->products()->delete();

        $category->delete();

        return redirect()->back()
            ->with(['message' => ['تم حذف القسن بنجاح', 'success']]);
    }
}