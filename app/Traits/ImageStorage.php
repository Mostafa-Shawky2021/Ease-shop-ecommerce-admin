<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait ImageStorage
{
    private static function storeImages(array $images, string $path, Model $model = null)
    {

        $imagesPath = null;

        if (is_array($images)) {

            $imagesPath = collect($images)->map(function ($img) use ($path, $model) {
                $imagePath = $img->store($path);
                $image = new Image(['url' => $imagePath]);
                $model ? $model->images()->save($image) : null;

                return $imagePath;
            });

        }

        return $imagesPath;
    }
}