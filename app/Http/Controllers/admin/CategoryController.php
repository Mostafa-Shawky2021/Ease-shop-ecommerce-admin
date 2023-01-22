<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::paginate(7);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)
            ->get();

        return view('categories.create', compact('categories'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'categoryName' => 'required|min:3|unique:categories,cat_name',
            'categoryImage' => 'sometimes|mimes:jpg,jpeg,png,gif',
        ]);
        $filePath = null;
        if ($request->has('categoryImage')) {
            $filePath = $request->file('categoryImage')
                ->store('images/categories');
        }
        Category::create([
            'cat_name' => $request->input('categoryName'),
            'image' => $filePath,
            'description' => $request->input('description'),
            'parent_id' => $request->input('parentId'),
        ]);

        return redirect()
            ->route('categories.index')
            ->with([
                'message' => ['Category Added Successfully', 'success']
            ]);


    }

}