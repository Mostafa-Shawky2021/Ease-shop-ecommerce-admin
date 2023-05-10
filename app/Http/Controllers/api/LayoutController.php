<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Footer;


class LayoutController extends Controller
{
    //
    public function index()
    {

        $carouselHomepage = Carousel::with('images')->first();
        $footerData = Footer::first();

        return response([
            'data' => [
                'carousel_content' => $carouselHomepage,
                'footer_data' => $footerData
            ]
        ], 200);
    }

}