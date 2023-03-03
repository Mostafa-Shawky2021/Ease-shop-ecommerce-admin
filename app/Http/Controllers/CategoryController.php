<?php

namespace App\Http\Controllers;

use App\Lib\FilterProducts;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class CategoryController extends Controller
{
    use FilterProducts;
    private static $paginationNumber = 25;
    public function index()
    {

        $categories = Category::with('subCategories')->get();

        if ($categories->isEmpty()) {
            return response(['Message' => 'Sorry no category in database'], 200);
        }
        return response($categories);
    }
    public function categoryProducts(Request $request, $categorySlug)
    {

        $category = Category::select(['id', 'cat_name'])
            ->firstWhere('cat_slug', $categorySlug);


        if (!$category) {
            return response(['Message' => 'Sorry no category Exist with slug'], 200);
        }

        $subCategories = Category::select('id')
            ->where('parent_id', $category->id)
            ->get();

        $categoriesId = $subCategories->map(fn($subCategory) => $subCategory->id);

        $categoriesId->prepend($category->id);

        $product = new Product();

        $products = $product->whereIn('category_id', $categoriesId);

        $queryFilterCount = collect($request->query())->count();

        if ($queryFilterCount > 1) {

            $filteredProduct = $this
                ->filterProducts($request, $products)
                ->paginate(static::$paginationNumber);

            if ($filteredProduct->isNotEmpty()) {

                return response([
                    'category' => $category,
                    'products' => $filteredProduct->items(),
                    'meta_pagination' => [
                        'current_page' => $filteredProduct->currentPage(),
                        'per_page' => $filteredProduct->perPage(),
                        'total' => $filteredProduct->total(),
                        'first_page_url' => $filteredProduct->url(1),
                        'last_page_url' => $filteredProduct > url($filteredProduct->lastPage()),
                        'next_page_url' => $filteredProduct->nextPageUrl(),
                        'prev_page_url' => $filteredProduct->previousPageUrl(),
                    ]
                ]);
            }
            return response([
                'Message' => 'Sorry no Products Category with filteration rules'
            ], 200);

        }

        $products = $product->paginate(static::$paginationNumber);

        if ($products->isNotEmpty()) {

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
            ], 200);

        }

        return response([
            'Message' => 'Sorry no product in that category',
        ], 200);



    }
    public function randomCategories()
    {
        $randomCategories = Category::select(['id', 'cat_name', 'cat_slug'])
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