<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


trait FilterProducts
{
    private $productModelFilter = null;
    private $limitFilter = null;
    private function filterProductByName($productName)
    {

        $this->productModelFilter =
            $this->productModelFilter
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where(
                    function (Builder $query) use ($productName) {
                        return $query->where('product_name', 'LIKE', "%$productName%")
                            ->orWhere('brand', 'LIKE', "%$productName%")
                            ->orWhere('cat_name', 'LIKE', "%$productName%");

                    }
                );
    }

    private function productWithOffers()
    {
        $this->productModelFilter = $this->productModelFilter->whereNotNull('price_discount');
    }

    private function filterProductByPrice($priceRange)
    {
        preg_match_all('/\d+/', $priceRange, $match);

        $matchingCollection = collect($match[0])
            ->map(fn($element) => intval($element))
            ->sort()
            ->slice(0, 2);

        // in case no matching default fitler
        if ($matchingCollection->isEmpty()) {
            $matchingCollection[0] = 50;
            $matchingCollection[1] = 10000;
        } else if ($matchingCollection->count() == 1) {
            $matchingCollection[1] = 10000;
        }

        $this->productModelFilter =
            $this->productModelFilter
                ->whereRaw('if(price_discount,price_discount,price) between ? and ?', $matchingCollection->toArray());
    }

    private function filterProductBySize($querySizes)
    {
        $sizes = explode('-', $querySizes);
        $this->productModelFilter =
            $this->productModelFilter->whereHas(
                'sizes',
                function (Builder $query) use ($sizes) {
                    $query->whereIn('name', $sizes);
                }
            );
    }
    private function filterProductByColors($queryColors)
    {
        $colors = explode('-', $queryColors);
        $this->productModelFilter =
            $this->productModelFilter->whereHas(
                'colors',
                function (Builder $query) use ($colors) {
                    $query->whereIn('name', $colors);
                }
            );
    }

    private function filterbyLatestProduct()
    {
        $this->productModelFilter = $this->productModelFilter->latest('id');
    }
    private function filterProducts(Request $request, $product)
    {

        $this->productModelFilter = $product;

        if ($request->has('productname')) {
            $productName = urldecode($request->query('productname'));
            $this->filterProductByName($productName);
        }

        if ($request->has('limit')) {
            $limitNumber = $request->query('limit');
            $this->limitFilter = intval($limitNumber);
        }

        if ($request->has('offers')) {
            $this->productWithOffers();
        }

        if ($request->has('price')) {
            $queryPrice = $request->query('price');
            $this->filterProductByPrice($queryPrice);

        }

        if ($request->has('sizes')) {
            $querySizes = $request->query('sizes');
            $this->filterProductBySize($querySizes);

        }

        if ($request->has('colors')) {
            $queryColors = $request->query('colors');
            $this->filterProductByColors($queryColors);
        }

        if ($request->has('latest')) {
            $this->filterbyLatestProduct();
        }

        return $this->limitFilter
            ? $this->productModelFilter->paginate($this->limitFilter)
            : $this->productModelFilter->paginate(static::$paginationNumber);
    }
}

?>