<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

    public function update(ProductForm $request, Product $product)
    {
        $imagePath = null;

        $validatedInputs = $request->safe()
            ->except('color_id', 'size_id', 'old_image');

        if ($request->has('image')) {

            $brandImagePath = $request->file('image')
                ->store('storage/products');

            Storage::exists($product->image) ? Storage::delete($product->image) : '';

            $validatedInputs['image'] = $brandImagePath;
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

        $product->update($validatedInputs);

        if ($request->input('color_id') === null && $product->colors()->exists()) {
            $product->colors()->detach();

        } else if ($request->filled('color_id')) {
            $product->colors()->sync(explode("|", $request->input('color_id')));
        }

        if ($request->input('size_id') === null && $product->sizes()->exists()) {
            $product->sizes()->detach();

        } else if ($request->filled('size_id')) {
            $product->sizes()->sync(explode("|", $request->input('size_id')));
        }

        return redirect()
            ->route('products.index')
            ->with(['Message' => ['تم تحديث المنتج بنجاح', 'success']]);


    }
}