<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {

        // check if there are url filter data
        $queryFilter = collect($request->query())->isEmpty();
        if (!$queryFilter) {
            return $this->filterProductsQuery($request);
        } else {

            if ($request->query('page')) {

                $products = Product::with(['colors', 'sizes'])->paginate(25);


                if ($products->isEmpty()) {
                    return response([
                        'Message' => 'sorry no produts exist'
                    ], 200);
                }
                return response([
                    'products' => $products->items(),
                    'meta_pagination' => [
                        'current_page' => $products->currentPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                        'first_page_url' => $products->url(1),
                        'last_page_url' => $products->url($products->lastPage()),
                        'next_page_url' => $products->nextPageUrl(),
                        'prev_page_url' => $products->previousPageUrl(),
                    ]
                ]);
            } else {
                $products = Product::with(['colors', 'sizes'])->get();
                if ($products->isEmpty()) {
                    return response([
                        'Message' => 'sorry no produts exist',
                        200
                    ]);
                }
                return response($products);
            }
        }

    }
    private function filterProductsQuery(Request $request)
    {

        $filterQueryProducts = null;

        if ($request->query('productname')) {

            $productName = $request->query('productname');

            $filterQueryProducts = Product::where(
                function (Builder $query) use ($productName) {
                    return $query->where('product_name', 'LIKE', "%$productName%")
                        ->orWhere('brand', 'LIKE', "%$productName%");
                }
            );
        }
        if ($request->query('price')) {
            $priceRange = explode('-', $request->query('price'));

            if ($filterQueryProducts) {
                $filterQueryProducts->whereBetween('price', $priceRange);

            } else {
                $filterQueryProducts = Product::whereBetween('price', $priceRange);
            }

        }
        if ($request->query('sizes')) {

            $sizes = explode('-', $request->query('sizes'));

            if ($filterQueryProducts) {

                $filterQueryProducts->whereHas(
                    'sizes',
                    function (Builder $query) use ($sizes) {
                        $query->whereIn('name', $sizes);
                    }
                );

            } else {
                $filterQueryProducts = Product::whereHas(
                    'sizes',
                    function (Builder $query) use ($sizes) {
                        $query->whereIn('name', $sizes);
                    }
                );
            }
        }
        if ($request->query('colors')) {

            if ($filterQueryProducts) {
                $colors = explode('-', $request->query('colors'));
                $filterQueryProducts->whereHas(
                    'colors',
                    function (Builder $query) use ($colors) {
                        $query->whereIn('name', $colors);
                    }
                );

            } else {
                $colors = explode('-', $request->query('colors'));
                $filterQueryProducts = Product::whereHas(
                    'colors',
                    function (Builder $query) use ($colors) {
                        $query->whereIn('name', $colors);
                    }
                );
            }

        }
        $filterQueryProductsPagination = $filterQueryProducts->paginate(5);

        if (!$filterQueryProductsPagination->isEmpty()) {

            return response([
                'products' => $filterQueryProductsPagination->items(),
                'meta_pagination' => [
                    'current_page' => $filterQueryProductsPagination->currentPage(),
                    'per_page' => $filterQueryProductsPagination->perPage(),
                    'total' => $filterQueryProductsPagination->total(),
                    'first_page_url' => $filterQueryProductsPagination->url(1),
                    'last_page_url' => $filterQueryProductsPagination->url($filterQueryProductsPagination->lastPage()),
                    'next_page_url' => $filterQueryProductsPagination->nextPageUrl(),
                    'prev_page_url' => $filterQueryProductsPagination->previousPageUrl(),
                ]
            ]);
        }
        return response(['Message' => 'Sorry no product exist']);

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