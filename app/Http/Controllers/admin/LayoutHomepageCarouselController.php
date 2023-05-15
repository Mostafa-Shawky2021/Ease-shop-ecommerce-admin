<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Http\Requests\admin\StoreCarouselRequest;
use Illuminate\Support\Facades\Storage;

use App\Models\Carousel;
use App\Traits\ImageStorage;
use App\Models\Image;

class LayoutHomepageCarouselController extends Controller
{
    //
    use ImageStorage;
    public function index(Request $request)
    {

        $carouselHomePage = Carousel::first();
        return view('layoutfront.homepage.carousel.index', compact('carouselHomePage'));
    }
    public function create()
    {
        return view('layoutfront.homepage.carousel.create');
    }

    public function store(StoreCarouselRequest $request)
    {
        $validatedInputs = $request->safe()->except('images');
        // we only allow one record in database
        Carousel::query()->delete();
        $carousel = Carousel::create($validatedInputs);
        if ($request->has('images')) {
            static::storeImage(
                $request->file('images'),
                'layout/homepage/carousel',
                $carousel,
                1600
            );

        }

        return redirect()
            ->route('carousel.index')
            ->with([
                'message' => ['تم اضافة المحتوي بنجاح', 'info']
            ]);
    }

    public function edit(Carousel $carousel)
    {

        return view('layoutfront.homepage.carousel.edit', compact('carousel'));

    }

    public function update(Request $request, Carousel $carousel)
    {
        $validatedInputs = $request->except('old_image', 'images');


        // Check if request payload contain images or contain empty old images string
        // empty old images meaning the user deleted the prev images 
        if ($request->has('images') || !$request->input('old_images')) {

            // if there old images delete them
            if ($carousel->images()->exists()) {

                $carousel->images->each(fn(Image $image) =>
                    Storage::exists($image->url) ? Storage::delete($image->url) : '');

                $carousel->images()->delete();
            }
        }

        if ($request->has('images')) {

            static::storeImage(
                $request->file('images'),
                'layout/homepage/carousel',
                $carousel
            );
        }
        if ($carousel->update($validatedInputs)) {
            return redirect()
                ->route('carousel.index')
                ->with(['message' => ['تم تحديث السليدر بنجاح', 'success']]);
        }
        return redirect()
            ->route('carousel.index')
            ->with(['message' => ['حدثت مشكله اثناء التعديل حاول مره اخري', 'error']]);
    }

    public function destroy(Carousel $carousel)
    {

        $carousel->images->each(fn(Image $image) =>
            Storage::exists($image->url) ? Storage::delete($image->url) : null);

        if ($carousel->delete()) {
            return redirect()
                ->route('carousel.index')
                ->with(['message' => ['تم حذف السليدر بنجاح', 'warning']]);
        }

        return redirect()
            ->route('carousel.index')
            ->with(['message' => ['حدثت مشكله اثناء التعديل حاول مره اخري', 'warning']]);
    }
}