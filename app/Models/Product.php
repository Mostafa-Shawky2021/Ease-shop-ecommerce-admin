<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\ResourceStatus;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{

    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use ResourceStatus;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        /*
         * inject application url to images in case its stored in our application
         * products/img.png will be injected with  http://example.com/storage/producs/img1.png
         */
        if (request()->ajax()) {

            static::retrieved(function ($product) {

                $isResoruceInternal = static::isResoruceInternal($product->image);
                // this is because datatable is ajax requests so we need escape inject
                // the path of the resoruce so laravel storage api can handle its pathes
                $excludeRouteName = !request()->routeIs('products.deleteMultiple');
                if ($isResoruceInternal && $product->image && $excludeRouteName) {

                    $product->image = request()->schemeAndHttpHost() . '/storage/' . $product->image;
                }
            });
        }
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot([
                'size',
                'color',
                'quantity'
            ])->using(OrderProduct::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function sluggable(): array
    {
        return [
            'product_slug' => [
                'source' => 'product_name'
            ]
        ];
    }


    public function deleteProductVariant()
    {
        $this->sizes()->detach();
        $this->colors()->detach();

        return true;
    }
}
