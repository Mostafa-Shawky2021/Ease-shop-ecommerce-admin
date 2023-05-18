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
        /*
         * inject application url to images in case its stored in our application
         * products/img.png will be injected with http://example.com/storage/producs/img1.png
         */
        if (request()->ajax()) {

            static::retrieved(function ($image) {

                // this is because datatable is ajax requests so we need escape inject
                // the path of the resoruce so laravel storage api can handle its pathes
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