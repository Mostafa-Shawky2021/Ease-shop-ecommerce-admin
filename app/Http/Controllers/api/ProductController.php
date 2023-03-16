<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Lib\FilterProducts;
use App\Models\Product;

class ProductController extends Controller
{

    use FilterProducts;
    private static $paginationNumber = 25;
    public function index(Request $request)
    {
        // check if there are url filter data
        $queryFilterCount = collect($request->except('page'))->count();
        // greater than meaning the query contaienr query fitler string 
        if ($queryFilterCount > 0) {

            $product = new Product();
            $filteredProduct = $this->filterProducts($request, $product);

            if ($filteredProduct->isNotEmpty()) {

                return response([
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
                'Message' => 'Sorry no Products with filteration rules'
            ], 200);

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
            ['Message' => 'Sorry no product exists'],
            200
        );
    }

    public function latestProduct()
    {
        $productLimit = 6;
        $products = Product::with('images')
            ->orderBy('id', 'desc')
            ->limit($productLimit)
            ->get();
        if (!$products->isEmpty()) {
            return response($products);
        }
        return response(['Message' => 'Sorry no product exist',], 200);

    }

    public function show($productSlug)
    {
        $product = Product::with(['category', 'images', 'colors', 'sizes'])
            ->firstWhere('product_slug', $productSlug);
        if ($product) {
            return response($product, 200);
        }
        return response(['Message' => 'Sorry no product exist',], 200);
    }

    public function relatedProduct(Request $request, $productSlug)
    {

        $productLimit = 8;

        $product = Product::firstWhere('product_slug', $productSlug);

        if ($product) {
            $productBrand = $product->brand;
            $productCategory = $product->category_id;

            // $productsWithBrand = Product::where('brand', $productBrand)
            //     ->where('id', '!=', $productId)
            //     ->limit($productLimit)
            //     ->get();

            // if (!$productsWithBrand->isEmpty()) {
            //     return response($productsWithBrand);
            // }

            $products = Product::where('category_id', $productCategory)
                ->where('product_slug', '!=', $productSlug)
                ->limit($productLimit)
                ->get();

            return response($products);

        } else {
            return response([
                'message' => 'no product with that id',
            ], 200);
        }

    }

    public function recentView(Request $request)
    {
        $productsId = $request->input('ids');
        $recentProductsView = Product::whereIn('id', $productsId)
            ->get();
        return response($recentProductsView);
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