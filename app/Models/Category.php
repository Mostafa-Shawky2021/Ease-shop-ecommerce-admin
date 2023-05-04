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

    public static function boot()
    {
        parent::boot();

        if (request()->ajax()) {
            static::retrieved(function ($category) {
                $isResoruceInternal = static::isResoruceInternal($category->image);
                $excludeRouteName = !request()->routeIs('categories.deleteMultiple');
                if ($isResoruceInternal && $category->image && $excludeRouteName) {
                    $category->image = request()->
                        schemeAndHttpHost() . '/storage/' . $category->image;
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