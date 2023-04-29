<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\DataTables\admin\ProductsDataTable;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Http\Requests\admin\StoreProductForm;
use App\Models\Image;
use App\Traits\ImageStorage;


class ProductController extends Controller
{
    use ImageStorage;
    public function index(ProductsDataTable $dataTable)
    {

        return $dataTable->render('products.index');
    }
    public function create()
    {

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $brands = Brand::all();

        return view('products.create', compact('categories', 'colors', 'sizes', 'brands'));
    }

    public function store(StoreProductForm $request)
    {

        $brandImagePath = null;

        $brandImagePath = $request->has('image')
            ? $request->file('image')->store('products')
            : null;

        $productinputFields = $request->safe()
            ->except([
                'size_id',
                'color_id',
                'old_image',
                'old_images',
                'productImageThumbnails'
            ]);

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
            self::storeImages($imageThumbnails, 'products', $product);
        }

        return redirect()
            ->route('products.index')
            ->with(['message' => ['تم اضافة المنتج بنجاح', 'success']]);
    }

    public function edit(Product $product)
    {

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $brands = Brand::all();

        return view(
            'products.edit',
            compact(
                'product',
                'categories',
                'colors',
                'sizes',
                'brands'
            )
        );
    }

    public function update(StoreProductForm $request, Product $product)
    {

        $validatedInputs = $request->safe()
            ->except([
                'color_id',
                'size_id',
                'productImageThumbnails'
            ]);

        $brandImagePath = null;

        if ($request->has('image')) {

            $brandImagePath = $request->file('image')->store('products');
            $validatedInputs['image'] = $brandImagePath;

            if ($product->image) {
                Storage::exists($product->image) ? Storage::delete($product->image) : null;
            }

        }

        // Check if request payload contain images thumbnails or contain empty old images string
        // empty old images meaning the user deleted the prev thubmnails 
        if ($request->has('productImageThumbnails') || !$request->input('old_images')) {

            if ($product->images()->exists()) {

                $product->images->each(fn(Image $image) =>
                    Storage::exists($image->url) ? Storage::delete($image->url) : '');

                $product->images()->delete();
            }

            $imageThumbnails = $request->file('productImageThumbnails');

            $request->has('productImageThumbnails')
                ? self::storeImages($imageThumbnails, 'products', $product)
                : null;

        }

        $product->update($validatedInputs);

        // null meaning that user deleted the the old color in case it were exist in last time
        // so need to check if null and there are color related to that product
        if ($request->input('color_id') === null && $product->colors()->exists()) {
            $product->colors()->detach();

            // user choose new value 
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

    public function destroy(Request $request, Product $product)
    {
        $productStatus = $request->query('status');

        if ($productStatus === 'trashed') {

            $product->deleteProductVariant();
            $product->orders()->detach();

            if ($product->image)
                Storage::exists($product->image) ? Storage::delete($product->image)
                    : null;

            $product->images->each(fn(Image $image) =>
                Storage::exists($image->url) ? Storage::delete($image->url) : null);
            $product->images()->delete();
            $product->forceDelete();
        } else
            $product->delete();


        return redirect()
            ->back()
            ->with(['message' => ['تم حذف المنتج بنجاح', 'success']]);

    }

    public function deleteMultipleProducts(Request $request)
    {
        if ($request->ajax()) {

            $products = Product::whereIn('id', $request->input('id'));

            $deletedCount = 0;

            if ($request->query('status') === 'trashed') {

                $products->withTrashed()->each(function ($product) {

                    $product->deleteProductVariant();

                    if ($product->image) {

                        Storage::exists($product->image)
                            ? Storage::delete($product->image)
                            : null;
                    }

                });

                $deletedCount = $products->forceDelete();

            } else
                $deletedCount = $products->delete();

            if ($deletedCount > 0) {

                return response([
                    'message' => 'Products deleted successfully'
                ], 200);

            }
            return response([
                'message' => 'no products found'
            ], 404);
        }
    }

    public function restoreProduct(Product $product)
    {

        $product->restore();
        return redirect()->back()
            ->with(['message' => ['تم استعادة المنتج بنجاح', 'success']]);
    }

    public function restoreMultipleProducts(Request $request)
    {

        if ($request->ajax()) {
            $restoredCount = Product::withTrashed()
                ->whereIn('id', $request->input('id'))
                ->restore();

            if ($restoredCount > 0) {
                return response([
                    'message' => 'products ' . $restoredCount . 'successfully restored'
                ], 200);
            }
            return response([
                'message' => 'no products to restore'
            ], 404);
        }
    }

}