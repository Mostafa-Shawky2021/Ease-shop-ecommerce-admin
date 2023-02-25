<?php

namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait FilterProducts
{

    private function filterProducts(Request $request, $model)
    {

        if ($request->has('productname')) {

            $productName = $request->query('productname');

            $model = $model->where(
                function (Builder $query) use ($productName) {
                    return $query->where('product_name', 'LIKE', "%$productName%")
                        ->orWhere('brand', 'LIKE', "%$productName%");
                }
            );

        }
        if ($request->has('price')) {

            $priceRange = explode('-', $request->query('price'));
            $model = $model->whereBetween('price', $priceRange);
        }

        if ($request->has('sizes')) {

            $sizes = explode('-', $request->query('sizes'));
            $model = $model->whereHas(
                'sizes',
                function (Builder $query) use ($sizes) {
                    $query->whereIn('name', $sizes);
                }
            );
        }

        if ($request->has('colors')) {
            $colors = explode('-', $request->query('colors'));
            $model = $model->whereHas(
                'colors',
                function (Builder $query) use ($colors) {
                    $query->whereIn('name', $colors);
                }
            );
        }

        return $model;
    }
}

?>