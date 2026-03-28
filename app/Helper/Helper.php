<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    public static function uploadFile(?object $file, string $folder): ?string
    {
        if(!$file) {
            return null;
        }

        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $uploaded = Storage::putFileAs("public/{$folder}", $file, $fileName);

        if(!$uploaded) {
        return null;
        }

        return "{$folder}/{$fileName}";
    }

    public static function deleteFile(?string $path): void
    {
        if($path && Storage::exists("public/{$path}")) {
            Storage::delete("public/{$path}");
        }
    }
}
