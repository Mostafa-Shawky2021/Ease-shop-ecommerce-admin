<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ResourceStatus;

class Image extends Model
{
    use HasFactory;
    use ResourceStatus;
    protected $fillable = ['url'];

    public static function boot()
    {
        parent::boot();

        if (request()->ajax()) {

            static::retrieved(function ($image) {
                $excludeRouteName = !request()->routeIs('*.deleteMultiple');
                $isResoruceInternal = static::isResoruceInternal($image->url);
                if ($isResoruceInternal && $excludeRouteName) {
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