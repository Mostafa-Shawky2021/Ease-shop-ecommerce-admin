<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Image;
use ImageIntervention;

trait ImageStorage
{

    // store image in file system and return the stored path
    private static function storeImage(array|UploadedFile $uploadedImage, string $path, Model $model = null,$resizeWidth=1000)
    {

        if (is_array($uploadedImage)) {

            $imagesPath = collect($uploadedImage)->map(
                function ($uploadedImage) use ($path, $model,$resizeWidth) {
                    $imageName = $uploadedImage->hashName();
                    Storage::exists($path) ?: Storage::makeDirectory($path);
                    $imagePath = storage_path("app/public/$path/" . $imageName);
                    ImageIntervention::make($uploadedImage)
                        ->resize($resizeWidth,
                         null, 
                         fn($constraint) => $constraint->aspectRatio())
                        ->save($imagePath);

                    $image = new Image(['url' => "$path/$imageName"]);
                    $model ? $model->images()->save($image) : null;
                    return "$path/$imageName";
                }
            );
            return $imagesPath;
        } else {
            $imageName = $uploadedImage->hashName();
            Storage::exists($path) ?: Storage::makeDirectory($path);
            $imagePath = storage_path("app/public/$path/" . $imageName);

            ImageIntervention::make($uploadedImage)
                ->resize($resizeWidth, null, fn($constraint) => $constraint->aspectRatio())
                ->save($imagePath);
            return "$path/$imageName";
        }

        return false;
    }
}