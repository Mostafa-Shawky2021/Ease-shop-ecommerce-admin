<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Traits\FilterProducts;
use App\Models\Product;


class CategoryController extends Controller
{
    use FilterProducts;
    private static $paginationNumber = 25;

    public function index(Request $request)
    {

        $categoriesQuery = Category::with([
            'subCategories' => function ($query) {
                $query->withCount('products');
            }
        ])->withCount('products')
            ->orderByDesc('id');

        if ($request->has('limit')) $categoriesQuery->limit($request->query("limit"));

        $categoriesResult = $categoriesQuery->get();

        if ($categoriesResult->isEmpty())
            return response(['message' => 'Sorry no categories in database'], 404);

        return response($categoriesResult, 200);
    }
    public function categoryProducts(Request $request, $categorySlug)
    {

        $category = Category::select(['id', 'cat_name'])
            ->firstWhere('cat_slug', $categorySlug);

        if (!$category)
            return response(
                ['message' => 'Sorry no category Exist with slug'],
                404
            );


        $subCategories = Category::select('id')
            ->where('parent_id', $category->id)
            ->get();

        $categoriesId = $subCategories->map(fn ($subCategory) => $subCategory->id);

        $categoriesId->prepend($category->id);

        $product = Product::query();

        $products = $product->whereIn('category_id', $categoriesId);

        $queryFilterCount = collect($request->except('page'))->count();

        if ($queryFilterCount > 0) {

            $filteredProduct = $this->filterProducts($request, $products);

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
                'message' => 'Sorry no Products Category with filteration rules'
            ], 200);
        }

        $products = $product->with(['colors', 'sizes'])
            ->paginate(static::$paginationNumber);

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
            'message' => 'Sorry no product in that category',
        ], 404);
    }
    public function randomCategoriesProducts()
    {
        $randomCategories = Category::select(['id', 'cat_name', 'cat_slug'])
            ->has('products')
            ->limit(8)
            ->inRandomOrder()
            ->get();

        foreach ($randomCategories as $index => $category) {
            $categoryProducts = $category->products()
                ->with(['colors', 'sizes'])
                ->limit(8)
                ->inRandomOrder()
                ->get();
            $randomCategories[$index]->products = $categoryProducts;
        }

        if ($randomCategories->isEmpty())
            return response(
                ['message' => 'Sorry no categories products exist'],
                200
            );


        return response(['data' => $randomCategories], 200);
    }

    public function subCategories($category)
    {
        $category = Category::where('cat_name', $category)
            ->first();
        if ($category) {
            $subCategories = $category->subCategories;
            return response($subCategories);
        }

        return response([
            'message' => 'sorry no subcategory exist for that category',
        ], 404);
    }
}
