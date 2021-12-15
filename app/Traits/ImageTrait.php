<?php
namespace App\Traits;
use Intervention\Image\Facades\Image;
Trait ImageTrait
{
    function saveImage($folder ,$photo){


        $file_name=$photo->hashName();

        Image::make($photo)->save(public_path($folder.$file_name));


        return $file_name;
    }

}


