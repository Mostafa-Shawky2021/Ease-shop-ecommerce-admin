<?php

namespace App\Traits;



use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait FilterProducts
{
    private $productModelFilter = null;
    private $limitFilter = null;

    private function filterProducts(Request $request, Builder|QueryBuilder $query)
    {

        $this->productModelFilter = $query;

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

        if ($request->has('brands')) {
            $queryBrands = urldecode($request->query('brands'));
            $this->filterProductByBrands($queryBrands);
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

        if ($request->has('random')) {

            $this->filterbyRandomProduct();
        }
        return $this->limitFilter
            ? $this->productModelFilter->with(['colors', 'sizes'])
                ->paginate($this->limitFilter)
            : $this->productModelFilter->with(['colors', 'sizes'])
                ->paginate(static::$paginationNumber);
    }

    private function filterProductByBrands($queryBrands)
    {
        $brands = explode('-', $queryBrands);

        $this->productModelFilter =
            $this->productModelFilter->whereHas(
                'brand',
                fn($query) => $query->whereIn('brand_name', $brands)
            );
    }
    private function filterProductByName($productName)
    {

        $this->productModelFilter =
            $this->productModelFilter
                ->select('products.*')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where(
                    function (Builder $query) use ($productName) {
                        return $query->where('products.product_name', 'LIKE', "%$productName%")
                            ->orWhere('categories.cat_name', 'LIKE', "%$productName%");

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

        // in case no matching default filter
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
                    $query->whereIn('size_name', $sizes);
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
                    $query->whereIn('color_name', $colors);
                }
            );
    }

    private function filterbyLatestProduct()
    {
        $this->productModelFilter = $this->productModelFilter->latest('id');
    }

    private function filterbyRandomProduct()
    {
        $this->productModelFilter = $this->productModelFilter->inRandomOrder();
    }

}

?>