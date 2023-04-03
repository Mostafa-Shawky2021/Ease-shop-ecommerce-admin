<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = [];


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
}