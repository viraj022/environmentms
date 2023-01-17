<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ClientApplicationHelper
{

    public static function downloadFile($url)
    {
        try {
            $target = basename($url);
            $contents = file_get_contents($url);

            return (Storage::put($target, $contents)) ? $target : false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
