<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable = [
        'product_name',
        'product_slug',
        'category_id',
        'price',
        'price_discount',
        'image',
        'brand',
        'short_description',
        'long_description',
        'color',
        'size'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
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