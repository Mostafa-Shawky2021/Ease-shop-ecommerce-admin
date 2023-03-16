<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\DataTables\admin\ProductsDataTable;
use App\Models\Category;
use App\Models\Product;
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
        return view('products.create', compact('categories'));
    }
    public function store(ProductForm $request)
    {

        $brandImagePath = null;


        if ($request->has('image')) {

            $brandImagePath = $request->file('image')->store('storage/products');

        }

        $inputsFields = $request->safe()->except('image');
        $inputsFields['image'] = $brandImagePath;

        $product = Product::create($inputsFields);

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