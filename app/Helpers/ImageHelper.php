<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get image URL safely, returning null if the image doesn't exist
     * 
     * @param string|null $path
     * @return string|null
     */
    public static function getImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        try {
            return Storage::url($path);
        } catch (\Throwable $e) {
            // Image doesn't exist on storage, return null
            return null;
        }
    }
}
