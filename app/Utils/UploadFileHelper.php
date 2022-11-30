<?php

namespace App\Utils;

class UploadFileHelper
{
    public static function uploadWithOriginalFileName($file, $path, $name)
    {
        $file->move($path, $name . '-' . str_replace(" ", "_", $file->getClientOriginalName()));
        return [
            'status' => true,
            'path' => $path . '/' . $name . '-' . str_replace(" ", "_", $file->getClientOriginalName())
        ];
    }

    public static function upload($file, $path, $name)
    {
        $file->move($path, $name . '.' . $file->getClientOriginalExtension());
        return [
            'status' => true,
            'path' => $path . '/' . $name . '.' . $file->getClientOriginalExtension()
        ];
    }
}
