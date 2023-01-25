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
        return response($products);
    }

    public function show($product)
    {
        $products = Product::with(['category', 'images'])
            ->where('product_slug', $product)
            ->first();
        if ($product) {
            return response($products, 200);
        }
        return response(['message' => 'no product found'], 404);


    }

    public function searchProduct(Request $request)
    {

        $products = Product::where('product_name', 'LIKE', "%{$request->query('key')}%")->get();
        return response($products);
    }

    public function relatedProduct(Request $request, $productId)
    {

        $products = [];
        $productLimit = 6;

        $product = Product::find($productId);
        if ($product) {

            $productBrand = $product->brand;
            $productCategory = $product->category_id;

            if ($productBrand) {
                $products = Product::where('brand', $productBrand)
                    ->where('id', '!=', $productId)
                    ->get();
                return response($products);
            }

            $products = Product::where('category_id', $productCategory)
                ->where('id', '!=', $productId)
                ->get();
            return response($products);

        } else {
            return response(['message' => 'no product with that id']);
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