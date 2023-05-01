<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    use HasImageUrl;
    protected $fillable = ['url'];

    public static function boot()
    {
        parent::boot();
        if (request()->ajax()) {
            static::retrieved(function ($image) {
                if (!static::isContainUrlSchema($image->url) && $image->url) {
                    $image->url = request()->
                        schemeAndHttpHost() . '/storage/' . $image->url;
                }

            });
        }


    }
    public function imageable()
    {
        return $this->morphTo();
    }
}