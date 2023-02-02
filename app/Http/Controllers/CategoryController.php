<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;

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


        $category = Category::select(['id', 'cat_name'])
            ->where('cat_slug', $categorySlug)
            ->first();
        if (!$category) {
            return response(['message' => 'Sorry not category with slug'], 404);
        }

        $subCategories = Category::select('id')
            ->where('parent_id', $category->id)
            ->get();

        $categoriesId = $subCategories->map(fn($subCategory) => $subCategory);
        $categoriesId->prepend($category->id);


        $products = Product::whereIn('category_id', $categoriesId)
            ->paginate(15);

        return response([
            'category' => $category,
            'products' => $products->items(),
            'meta_pagination' =>
            [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'first_page_url' => $products->url(1),
                'last_page_url' => $products->url($products->lastPage()),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ]
        ]);


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