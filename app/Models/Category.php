<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\HasImageUrl;


class Category extends Model
{
    use HasFactory, Sluggable, HasImageUrl;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        if (request()->ajax()) {
            static::retrieved(function ($category) {
                if (!static::isContainUrlSchema($category->image) && $category->image) {
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