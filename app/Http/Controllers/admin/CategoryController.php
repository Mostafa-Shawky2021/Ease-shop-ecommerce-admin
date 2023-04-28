<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreCategoryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DataTables\admin\CategoriesDataTable;
use App\Models\Category;

use ImageIntervention;

class CategoryController extends Controller
{
    //
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

            $filePath = $request->file('image')->store('categories', 'public');
            $validatedInput['image'] = $filePath;
        }

        if ($request->has('image_thumbnail')) {

            $filePath = $request->file('image_thumbnail')->store('categories', 'public');
            $validatedInput['image_thumbnail'] = $filePath;
        }

        if ($request->has('image_topcategory')) {
            $filePath = $request->file('image_topcategory')->store('categories', 'public');
            $validatedInput['image_topcategory'] = $filePath;
        }

        $category = Category::create($validatedInput);

        if ($request->ajax()) {
            return response([
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        }
        return redirect()->route('categories.index')
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
            $filePath = $request->file('image')->store('categories', 'public');
            $validatedInput['image'] = $filePath;
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

            $imageThumbnailPath = $request->file('image_thumbnail')->store('categories', 'public');
            $validatedInput['image_thumbnail'] = $imageThumbnailPath;
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

            $filePath = $request->file('image_topcategory')->store('categories', 'public');
            $validatedInput['image_topcategory'] = $filePath;
        }

        // in case oldimage field is empty meaning that user delete the image or it was firt uploaded image
        if ($request->input('image_topcategory') || !$request->input('old_image_topcategory')) {

            if ($category->image_topcategory) {
                Storage::exists($category->image_topcategory)
                    ? Storage::delete($category->image_topcategory)
                    : null;
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
            Storage::exists($category->image) ? Storage::delete($category->image) : null;
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