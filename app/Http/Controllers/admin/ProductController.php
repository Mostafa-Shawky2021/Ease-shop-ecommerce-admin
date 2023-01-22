<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\admin\ProductForm;
use App\Models\Image;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(7);
        return view('products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    public function store(ProductForm $request)
    {
        $brandImagePath = null;

        if ($request->validated()) {
            if ($request->has('productImage')) {
                $brandImagePath = $request->file('productImage')
                    ->store('images/products');
            }

            $product = Product::create([
                'category_id' => $request->input('categoryId'),
                'product_name' => $request->input('productName'),
                'price' => $request->input('price'),
                'price_discount' => $request->input('priceDiscount'),
                'image' => $brandImagePath,
                'brand' => $request->input('brandName'),
                'short_description' => $request->input('shortDescription'),
                'long_description' => $request->input('longDescription'),
                'color' => $request->input('color'),
                'size' => $request->input('size')
            ]);

            if ($request->has('productImageThumbnails')) {
                $imageThumbnails = $request->file('productImageThumbnails');
                foreach ($imageThumbnails as $img) {
                    $imageThumbnailPath = $img->store('images/products');
                    $image = new Image(['url' => $imageThumbnailPath]);
                    $product->images()->save($image);
                }

            }
            return redirect()
                ->route('products.index')
                ->with(['message' => ['Product Added Successfully', 'success']]);
        }
    }
    public function edit($product)
    {
        $product = Product::with('images')
            ->where('id', $product)
            ->first();

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(ProductForm $request, $product)
    {
        $product = Product::find($product);
        if ($request->validated()) {

            if ($request->has('productImage')) {

                $brandImagePath = $request->file('productImage')
                    ->store('images/products');
                if (Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }
                $product->image = $brandImagePath;
            }

            if ($request->has('productImageThumbnails')) {
                $product->images()->delete();
                $imageThumbnails = $request->file('productImageThumbnails');
                foreach ($imageThumbnails as $img) {
                    $imageThumbnailPath = $img->store('images/products');
                    $image = new Image(['url' => $imageThumbnailPath]);
                    $product->images()->save($image);
                }
            }
            $product->update([
                'category_id' => $request->input('categoryId'),
                'product_name' => $request->input('productName'),
                'price' => $request->input('price'),
                'price_discount' => $request->input('priceDiscount'),
                'brand' => $request->input('brandName'),
                'short_description' => $request->input('shortDescription'),
                'long_description' => $request->input('longDescription'),
                'color' => $request->input('color'),
                'size' => $request->input('size')
            ]);
            return redirect()
                ->route('products.index')
                ->with(['message' => ['Product Updated Successfully', 'success']]);

        }
    }
}