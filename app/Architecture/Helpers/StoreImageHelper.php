<?php

namespace App\Architecture\Helpers;

use Illuminate\Support\Facades\Storage;

class StoreImageHelper
{
    public function storageImage($img, $folderPath)
    {
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;

        $response = Storage::disk('public')->put($file, $image_base64);

        return [$response, $file];
    }
}
