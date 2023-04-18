<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    //
    public function index()
    {

        $colors = Color::paginate();
        return view('colors.index', compact('colors'));
    }
    public function create()
    {
        return view('colors.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([

            'colors_name' => 'required'
        ]);


        $colorsValueArray = collect(explode('|', $validated['colors_name']));

        $colorsValueArray->each(function ($color) {

            $colorsValue = explode(',', $color);
            $colorValueExist = Color::where('color_name', $colorsValue[0])->exists();

            if (!$colorValueExist)

                Color::create([
                    'color_name' => $colorsValue[0],
                    'color_value' => $colorsValue[1],
                ]);
        });

        return redirect()->route('colors.index');
    }

    public function edit(Color $color)
    {

        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {

        $validated = $request->validate([
            'colors_name' => 'required'
        ]);

        $colorValueToArr = explode(',', $validated['colors_name']);

        $colorExist = Color::where('color_name', $colorValueToArr[0])
            ->where('id', '!=', $color->id)
            ->exists();


        if ($colorExist) {
            return redirect()->back()
                ->with([
                    'message' => 'اسم اللون موجود مسبقاً'
                ]);
        }

        $color->update([
            'color_name' => $colorValueToArr[0],
            'color_value' => $colorValueToArr[1]
        ]);

        return redirect()
            ->route('colors.index')
            ->with(['message' => ['تم تحديث الون بنجاح', 'success']]);

    }

    public function destroy(Color $color)
    {
        $color->products()->detach();
        $color->delete();
        return redirect()
            ->route('colors.index')
            ->with(['Message' => ['تم حذف الون بنجاح', 'success']]);
    }
    public function deleteMultipleColor(Request $request)
    {
        if ($request->ajax()) {

            // detach product relation from intermediate table
            collect($request->input('id'))->each(function ($colorId) {
                $color = Color::find($colorId);
                if ($color)
                    $color->products()->detach();

            });

            // detach product relation from intermediate table
            $deletedCount = Color::whereIn('id', $request->input('id'))->delete();
            if ($deletedCount > 0) {
                return response([
                    'message' => 'colors deleted successfully'
                ], 200);

            }
            return response([
                'message' => 'no colors found'
            ], 404);
        }
    }

}