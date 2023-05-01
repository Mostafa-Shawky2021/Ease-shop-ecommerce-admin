<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreCategoryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DataTables\admin\CategoriesDataTable;
use App\Models\Category;
use App\Traits\ImageStorage;

class CategoryController extends Controller
{
    //
    use ImageStorage;
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('categories.index');

    }
    public function create()
    {

        $categories = Category::where('parent_id', null)
            ->get();

        return view('categories.create', compact('categories'));
    }
    public function store(StoreCategoryForm $request)
    {
        $validatedInput = $request->validated();

        if ($request->has('image')) {
            $imagePath = self::storeImage($request->file('image'), 'categories');
            $validatedInput['image'] = $imagePath;
        }

        if ($request->has('image_thumbnail')) {

            $imagePath = self::storeImage($request->file('image_thumbnail'), 'categories');
            $validatedInput['image_thumbnail'] = $imagePath;
        }

        if ($request->has('image_topcategory')) {
            $imagePath = self::storeImage($request->file('image_topcategory'), 'categories');
            $validatedInput['image_topcategory'] = $imagePath;
        }

        $category = Category::create($validatedInput);

        if ($request->ajax()) {
            return response([
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        }
        return redirect()
            ->route('categories.index')
            ->with([
                'message' => ['تم اضافة القسم بنجاح', 'success']
            ]);
    }
    public function edit(Category $category)
    {
        $categories = Category::where('parent_id', null)
            ->whereNot('id', $category->id)
            ->get();
        return view('categories.edit', compact('categories', 'category'));
    }
    public function update(StoreCategoryForm $request, Category $category)
    {

        $validatedInput = $request->validated();

        // store uploaded image
        if ($request->has('image')) {
            $imagePath = self::storeImage($request->file('image'), 'categories');
            $validatedInput['image'] = $imagePath;
        }

        // in case oldimage field is empty meaning that user delete the image or it was firt uploaded image
        if (!$request->input('old_image') || $request->has('image')) {

            if ($category->image) {
                Storage::exists($category->image)
                    ? Storage::delete($category->image)
                    : null;
                $category->image = null;
            }

        }

        if ($request->has('image_thumbnail')) {
            $imagePath = self::storeImage($request->file('image_thumbnail'), 'categories');
            $validatedInput['image_thumbnail'] = $imagePath;
        }

        // Check if request payload contain image thumbnail or contain empty old images string
        // empty old images meaning the user deleted the prev thubmnail 
        if ($request->has('image_thumbnail') || !$request->input('old_image_thumbnail')) {

            if ($category->image_thumbnail) {

                Storage::exists($category->image_thumbnail)
                    ? Storage::delete($category->image_thumbnail)
                    : null;
                $category->image_thumbnail = null;
            }
        }

        // store top category image
        if ($request->has('image_topcategory')) {
            $imagePath = self::storeImage($request->file('image_topcategory'), 'categories');
            $validatedInput['image_topcategory'] = $imagePath;
        }

        // in case oldimage field is empty meaning that user delete the image or it was firt uploaded image
        if ($request->has('image_topcategory') || !$request->input('old_image_topcategory')) {
            if ($category->image_topcategory) {
                Storage::exists($category->image_topcategory)
                    ? Storage::delete($category->image_topcategory)
                    : null;
                $category->image_topcategory = null;
            }
        }

        $category->update($validatedInput);

        return redirect()
            ->route('categories.index')
            ->with([
                'message' => ['تم اضافة القسم بنجاح', 'success']
            ]);
    }
    public function destroy(Category $category)
    {

        $category->subCategories()->delete();

        $category->products->each(function ($product) {
            // TODO::confirm user first
            $product->deleteProductVariant();
            $product->orders()->detach();
        });

        if ($category->image) {
            Storage::exists($category->image)
                ? Storage::delete($category->image)
                : null;
        }

        if ($category->image_topcategory) {
            Storage::exists($category->image_topcategory)
                ? Storage::delete($category->image_topcategory)
                : null;
        }
        if ($category->image_thumbnail) {
            Storage::exists($category->image_thumbnail)
                ? Storage::delete($category->image_thumbnail)
                : null;
        }

        $category->products()->delete();

        $category->delete();

        return redirect()->back()
            ->with(['message' => ['تم حذف القسن بنجاح', 'success']]);
    }

    public function deleteMultipleCategories(Request $request)
    {

        if ($request->ajax()) {

            $deletedCount = Category::whereIn('id', $request->input('id'))->delete();

            if ($deletedCount > 0) {
                return response([
                    'message' => 'Category deleted successfully'
                ], 200);

            }
            return response([
                'message' => 'no products found'
            ], 404);
        }
    }
}