<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\FilterProducts;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{

    use FilterProducts;

    private static $paginationNumber = 25;

    public function index(Request $request)
    {

        // check if there are url filter data
        $queryFilterCount = collect($request->except('page'))->count();
        // greater than meaning the query contain query fitler string 

        if ($queryFilterCount > 0) {

            $filteredProduct = $this->filterProducts($request, Product::query());

            if ($filteredProduct->isNotEmpty()) {

                return response(
                    [
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
                    ]
                );
            }
            return response([
                'Message' => 'Sorry no Products with filteration rules'
            ], 404);
        }

        $products = Product::with(['colors', 'sizes']);
        $productsPagination = $products->paginate(static::$paginationNumber);

        if ($productsPagination->isNotEmpty()) {

            return response([
                'products' => $productsPagination->items(),
                'meta_pagination' => [
                    'current_page' => $productsPagination->currentPage(),
                    'per_page' => $productsPagination->perPage(),
                    'total' => $productsPagination->total(),
                    'first_page_url' => $productsPagination->url(1),
                    'last_page_url' => $productsPagination > url($productsPagination->lastPage()),
                    'next_page_url' => $productsPagination->nextPageUrl(),
                    'prev_page_url' => $productsPagination->previousPageUrl(),
                ]
            ]);
        }
        return response(
            ['message' => 'Sorry no product exists'],
            404
        );
    }


    public function show(Request $request, Product $product)
    {

        $product->load('category', 'images', 'colors', 'sizes', 'brand');

        if ($product) return response($product, 200);

        return response(['Message' => 'Sorry no product exist'], 404);
    }

    public function relatedProduct(Request $request, $productSlug)
    {

        $productLimit = 8;

        $product = Product::firstWhere('product_slug', $productSlug);

        if (!$product) return response(['message' => 'Sorry no product with slug']);

        $productCategory = $product->category_id;
        $productBrand = $product->brand_id;

        $products = Product::where('product_slug', '!=', $productSlug)
            ->where(function (Builder $query) use ($productCategory, $productBrand) {
                $productCategory ? $query->where('category_id', $productCategory) : null;
                $productBrand ? $query->orWhere('brand_id', $productBrand) : null;
            })->limit($productLimit)
            ->get();


        if ($products->isEmpty())
            return  response(['Message' => 'Sorry no related products found'], 404);

        return response($products, 200);
    }

    public function randomProduct()
    {
        $productLimit = 6;
        $products = Product::inRandomOrder()
            ->limit($productLimit)
            ->get();
        return response($products);
    }

    public function offersProduct()
    {
        $productLimit = 6;
        $products = Product::whereNotNull('price_discount')
            ->limit($productLimit)
            ->get();

        return response($products);
    }
}
