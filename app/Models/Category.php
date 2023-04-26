<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Route;

class Category extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = [];

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

    public function imageThumbnail()
    {

        return $this->morphOne(Image::class, 'imageable');
    }

}