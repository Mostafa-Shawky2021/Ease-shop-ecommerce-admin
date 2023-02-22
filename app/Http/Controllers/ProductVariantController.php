<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;

class ProductVariantController extends Controller
{
    //
    public function index()
    {
        $colors = Color::all();
        $sizes = Size::all();

        return response([
            'colors' => $colors,
            'sizes' => $sizes,
        ], 200);

    }
}