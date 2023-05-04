<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\ResourceStatus;

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

        // inject the url schema to image path in case XMLHttpRequest is used
        if (request()->ajax()) {

            static::retrieved(function ($product) {

                $isResoruceInternal = static::isResoruceInternal($product->image);
                $excludeRouteName = !request()->routeIs('products.deleteMultiple');
                if ($isResoruceInternal && $product->image && $excludeRouteName) {

                    $product->image = request()->
                        schemeAndHttpHost() . '/storage/' . $product->image;
                }

            });
        }


    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot([
                'size',
                'color',
                'quantity'
            ]);

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