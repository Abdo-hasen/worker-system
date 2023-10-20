<?php

namespace App\Http\traits;

trait FileTrait
{
    private function uploadImage($path, $image, $old_image = null)
    {
        if ($old_image) {
            $this->deleteImage($path, $old_image);
        }

        $image_name = uuid_create() . "_" . $image->getClientOriginalName(); 
        $image->move(public_path($path), $image_name); 
        return $image_name; 
    }

    private function deleteImage($path, $old_image)
    {
        $image_path = public_path($path . $old_image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}