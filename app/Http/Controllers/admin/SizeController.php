<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Size;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    //
    public function index()
    {
        $sizes = Size::orderByDesc('id')->paginate();
        return view('sizes.index', compact('sizes'));
    }
    public function create()
    {
        return view('sizes.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'sizes_name' => 'required'
        ]);

        $sizesValueArray = collect(explode('|', $validated['sizes_name']));


        $sizesValueArray->each(function ($size) {
            $sizeValueExist = Size::where('size_name', $size)->exists();
            if (!$sizeValueExist)
                Size::create(['size_name' => $size]);
        });

        return redirect()->route('sizes.index');
    }

    public function edit(Size $size)
    {
        return view('sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {

        $validated = $request->validate([
            'size_name' => [
                'required',
                Rule::unique('sizes')->ignore($size->id ?? null)
            ]
        ]);

        $size->update($validated);

        return redirect()
            ->route('sizes.index')
            ->with(['message' => ['تم تحديث المقاس بنجاح', 'success']]);
    }

    public function destroy(Size $size)
    {

        $size->products()->detach();
        $size->delete();
        return redirect()
            ->route('sizes.index')
            ->with(['Message' => ['تم حذف المقاس بنجاح', 'success']]);
    }

    public function deleteMultipleSizes(Request $request)
    {
        if ($request->ajax()) {

            // detach product relation from intermediate table
            collect($request->input('id'))->each(function ($sizeId) {
                $size = Size::find($sizeId);
                if ($size)
                    $size->products()->detach();

            });

            // detach product relation from intermediate table
            $deletedCount = Size::whereIn('id', $request->input('id'))->delete();
            if ($deletedCount > 0) {
                return response([
                    'message' => 'sizes deleted successfully'
                ], 200);

            }
            return response([
                'message' => 'no sizes found'
            ], 404);
        }
    }

}