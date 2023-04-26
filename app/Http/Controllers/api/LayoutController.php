<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Carousel;


class LayoutController extends Controller
{
    //
    public function index()
    {

        $carouselHomepage = Carousel::with('images')->first();
        return response([
            'data' => ['carousel_content' => $carouselHomepage]
        ], 200);
    }
}