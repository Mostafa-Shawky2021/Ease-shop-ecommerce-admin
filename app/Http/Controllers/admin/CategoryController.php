<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DataTables\admin\CategoriesDataTable;
use App\Models\Category;
use App\Models\Image;

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
    public function store(CategoryForm $request)
    {

        $validatedInput = $request->validated();

        if ($request->has('image')) {

            $filePath = $request->file('image')->store('storage/categories');
            $validatedInput['image'] = $filePath;
        }

        $category = Category::create($validatedInput);

        if ($request->has('image_thumbnail')) {

            $filePath = $request->file('image_thumbnail')->store('storage/categories');
            $imageThumbnail = new Image(['url' => $filePath]);
            $category->imageThumbnail()->save($imageThumbnail);
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
    public function update(CategoryForm $request, Category $category)
    {

        $validatedInput = $request->validated();

        if ($request->has('image')) {

            $filePath = $request->file('image')->store('storage/categories');
            $validatedInput['image'] = $filePath;
            if ($category->image)
                Storage::exists($category->image) ? Storage::delete($category->image) : null;
        }

        $category->update($validatedInput);

        // Check if request payload contain images thumbnails or contain empty old images string
        // empty old images meaning the user deleted the prev thubmnail 
        if ($request->has('image_thumbnail') || !$request->input('old_image_thumbnail')) {

            if ($category->imageThumbnail()->exists()) {

                $imagePath = $category->imageThumbnail->url;
                Storage::exists($imagePath) ? Storage::delete($imagePath) : null;
                $category->imageThumbnail()->delete();
            }

            if ($request->has('image_thumbnail')) {

                $imageThumbnailPath = $request->file('image_thumbnail')->store('storage/categories');
                $imageThumbnail = new Image(['url' => $imageThumbnailPath]);
                $category->imageThumbnail()->save($imageThumbnail);
            }

        }
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
            $product->colors()->detach();
            $product->sizes()->detach();
            // TODO::confirm user first
            $product->orders()->detach();
        });

        if ($category->image) {
            Storage::exists($category->image) ? Storage::delete($category->image) : null;
        }
        if ($category->imageThumbnail()->exists()) {

            $thumbnailPath = $category->imageThumbnail->url;
            Storage::exists($thumbnailPath) ? Storage::delete($thumbnailPath) : null;
            $category->imageThumbnail()->delete();
        }
        $category->products()->delete();

        $category->delete();

        return redirect()->back()
            ->with(['message' => ['تم حذف القسن بنجاح', 'success']]);
    }
}