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
        $colors = Color::all();
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
}