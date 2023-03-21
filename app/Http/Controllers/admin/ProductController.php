<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\DataTables\admin\ProductsDataTable;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Http\Requests\admin\ProductForm;
use App\Models\Image;

class ProductController extends Controller
{
    //
    public function index(ProductsDataTable $dataTable)
    {

        return $dataTable->render('products.index');
    }
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('products.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(ProductForm $request)
    {
        // dd($request->all());
        $brandImagePath = null;

        $brandImagePath = $request->has('image')
            ? $request->file('image')->store('storage/products')
            : null;

        $productinputFields = $request->safe()->except(['image', 'size_id', 'color_id']);
        $productinputFields['image'] = $brandImagePath;

        $product = Product::create($productinputFields);

        if ($request->filled('color_id')) {
            $product->colors()
                ->attach(explode('|', $request->input('color_id')));
        }
        if ($request->filled('size_id')) {
            $product->sizes()
                ->attach(explode('|', $request->input('size_id')));
        }


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
            ->with(['message' => ['تم اضافة المنتج بنجاح', 'success']]);
    }
    public function edit($product)
    {
        $product = Product::with(['images', 'sizes', 'colors'])
            ->where('id', $product)
            ->first();

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('products.edit', compact('product', 'categories', 'colors', 'sizes'));
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