<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Size;

class SizeController extends Controller
{
    //
    public function index()
    {
        $sizes = Size::all();
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
}