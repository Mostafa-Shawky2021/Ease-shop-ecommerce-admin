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
            $colorValueExist = Color::where('color_name', $color)->exists();
            if (!$colorValueExist)
                Color::create(['color_name' => $color]);
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
            'color_name' => 'required|unique:colors'
        ]);

        $color->update($validated);

        return redirect()
            ->route('colors.index')
            ->with(['Message' => ['تم تحديث الون بنجاح', 'success']]);

    }

    public function destroy(Color $color)
    {
        $color->products()->detach();
        $color->delete();
        return redirect()
            ->route('colors.index')
            ->with(['Message' => ['تم حذف الون بنجاح', 'success']]);
    }

}