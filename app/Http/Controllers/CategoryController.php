<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {

        $categories = Category::with('subCategories')->get();
        if ($categories->isEmpty()) {
            return response('Sorry no category in database', 404);
        }
        return response($categories);
    }
    public function categoryProducts(Request $request, $categorySlug)
    {
        $categoryWithProducts = Category::with(['subCategories.products', 'products'])
            ->where('cat_slug', $categorySlug)
            ->get();

        if ($categoryWithProducts->isEmpty()) {
            return response(['message' => 'Sorry cat with that slug not found'], 404);
        }
        return response($categoryWithProducts);
    }
    public function randomCategories()
    {
        $randomCategories = Category::select(['id', 'cat_name'])
            ->has('products')
            ->limit(8)
            ->orderBy('id', 'desc')
            ->inRandomOrder()
            ->get();

        foreach ($randomCategories as $index => $category) {
            $categoryProducts = $category
                ->products()
                ->limit(5)
                ->get();
            $randomCategories[$index]->products = $categoryProducts;
        }

        if ($randomCategories->isEmpty()) {
            return response(['message' => 'Sorry no data exit'], 404);
        }
        return response($randomCategories);


    }




    public function subCategories($category)
    {
        $category = Category::where('cat_name', $category)
            ->first();
        if ($category) {
            $subCategories = $category->subCategories;
            return response($subCategories);
        }
        return [];
    }


}