<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\ResourceStatus;


class Category extends Model
{
    use HasFactory, Sluggable, ResourceStatus;
    protected $guarded = [];
    public  $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        /*
         * inject application url to images in case its stored in our application
         * products/img.png will be injected with http://example.com/storage/producs/img1.png
         */
        if (request()->ajax()) {
            static::retrieved(function ($category) {
                $isResoruceInternal = static::isResoruceInternal($category->image);
                // this is because datatable is ajax requests so we need escape inject the path of the resoruce so laravel storage api can handle its pathes
                $excludeRouteName = !request()->routeIs('categories.deleteMultiple');
                if ($isResoruceInternal && $excludeRouteName) {
                    $fullUrlPath = request()->schemeAndHttpHost() . '/storage/';
                    $category->image = $category->image ? $fullUrlPath . $category->image : null;
                    $category->image_thumbnail = $category->image_thumbnail ? $fullUrlPath . $category->image_thumbnail : null;
                }
            });
        }
    }

    public function sluggable(): array
    {
        return [
            'cat_slug' => [
                'source' => 'cat_name'
            ]
        ];
    }
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
