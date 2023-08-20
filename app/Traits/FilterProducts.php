<?php

namespace App\Traits;



use App\Models\OrderProduct;
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

        if ($request->has('categories')) {
            $this->filterProductByCategories($request->query('categories'));
        }
        if ($request->has('limit')) {
            $limitNumber = $request->query('limit');
            $this->limitFilter = intval($limitNumber);
        }
        if ($request->has('best-seller')) {
            $this->bestSellerProducts();
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
            $querySizes = urldecode($request->query('sizes'));
            $this->filterProductBySize($querySizes);
        }

        if ($request->has('colors')) {
            $queryColors = urldecode($request->query('colors'));
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

    private function filterProductByCategories($categoriesId)
    {
        $categoriesIdArr = explode('-', $categoriesId);
        $this->productModelFilter->whereIn('category_id', $categoriesIdArr);
    }
    private function filterProductByBrands($queryBrands)
    {
        $brands = explode('-', $queryBrands);

        $this->productModelFilter->whereHas(
            'brand',
            fn ($query) => $query->whereIn('brand_name', $brands)
        );
    }
    private function filterProductByName($productName)
    {
        $productNameToLower = '%' . trim(strtolower(($productName))) . '%';
        $this->productModelFilter
            ->select('products.*')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->where(function ($query) use ($productNameToLower) {
                $query->whereRaw('LOWER(products.product_name) LIKE ?', [$productNameToLower])
                    ->orWhereRaw('LOWER(categories.cat_name) LIKE ?', [$productNameToLower])
                    ->orWhereRaw('LOWER(brands.brand_name) LIKE ? ', [$productNameToLower]);
            });
    }
    private function bestSellerProducts()
    {
        // the best seller will be retrieved according to the quanaity for products within  
        // order product relationship
        $this->productModelFilter
            ->selectRaw('products.*, sum(order_product.quantity) as total_product_seller')
            ->join('order_product', 'products.id', 'order_product.product_id')
            ->groupBy('order_product.product_id', 'products.id')
            ->orderBy('total_product_seller', 'desc');
    }
    private function productWithOffers()
    {
        $this->productModelFilter->whereNotNull('price_discount');
    }

    private function filterProductByPrice($priceRange)
    {
        preg_match_all('/\d+/', $priceRange, $match);

        $matchingCollection = collect($match[0])
            ->sort()
            ->slice(0, 2);

        // in case no matching default filter
        if ($matchingCollection->isEmpty()) {
            $matchingCollection[0] = "50";
            $matchingCollection[1] = "10000";
        } else if ($matchingCollection->count() == 1) {
            $matchingCollection[1] = "10000";
        }

        $this->productModelFilter->where(function ($query) use ($matchingCollection) {
            $query->whereBetween('price_discount', $matchingCollection->toArray());
            $query->orWhereBetween('price', $matchingCollection->toArray());
        });
    }

    private function filterProductBySize($querySizes)
    {
        $sizes = explode('-', $querySizes);
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
        $this->productModelFilter->whereHas(
            'colors',
            function (Builder $query) use ($colors) {
                $query->whereIn('color_name', $colors);
            }
        );
    }

    private function filterbyLatestProduct()
    {
        $this->productModelFilter->latest('id');
    }

    private function filterbyRandomProduct()
    {
        $this->productModelFilter->inRandomOrder();
    }
}
