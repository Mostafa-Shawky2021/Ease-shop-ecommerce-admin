<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    //
    public function index()
    {
        $brands = Brand::paginate();
        return view('brands.index', compact('brands'));
    }
    public function create()
    {
        return view('brands.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brands_name' => 'required'
        ]);

        $brandsValueArray = collect(explode('|', $validated['brands_name']));

        $brandsValueArray->each(function ($brand) {
            $brandValueExist = Brand::where('brand_name', $brand)->exists();
            if (!$brandValueExist)
                Brand::create(['brand_name' => $brand]);
        });

        return redirect()->route('brands.index');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {

        $validated = $request->validate([
            'brand_name' => [
                'required',
                Rule::unique('brands')->ignore($brand->id ?? null)
            ],
        ]);

        $brand->update($validated);

        return redirect()
            ->route('brands.index')
            ->with(['message' => ['تم تحديث البراند بنجاح', 'success']]);

    }

    public function destroy(Brand $brand)
    {
        $brand->products()->detach();
        $brand->delete();
        return redirect()
            ->route('brands.index')
            ->with(['Message' => ['تم حذف البراند بنجاح', 'success']]);
    }
}