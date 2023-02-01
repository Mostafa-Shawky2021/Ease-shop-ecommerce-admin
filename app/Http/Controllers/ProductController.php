<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {

        $products = Product::all();
        if (!empty($products)) {
            return response($products, 200);
        }
        return response(['message' => 'sorry no produts exist', 404]);
    }

    public function latestProduct()
    {
        $productLimit = 6;
        $products = Product::with('images')
            ->orderBy('id', 'desc')
            ->limit($productLimit)
            ->get();
        if ($products->isEmpty()) {
            return response(
                [
                    'message' => 'no product found',
                    'data' => []
                ],
                200
            );
        }
        return response($products);
    }

    public function show($productSlug)
    {
        $product = Product::with(['category', 'images'])
            ->where('product_slug', $productSlug)
            ->first();
        if ($product) {
            return response($product, 200);
        }
        return response([
            'data' => [],
            'message' => 'no product found'
        ], 404);


    }

    public function searchProduct(Request $request)
    {

        $products = Product::where('product_name', 'LIKE', "%{$request->query('key')}%")->get();
        return response($products);
    }

    public function relatedProduct(Request $request, $productSlug)
    {

        $productLimit = 8;

        $product = Product::where('product_slug', $productSlug)->first();

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
                'data' => []
            ]);
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