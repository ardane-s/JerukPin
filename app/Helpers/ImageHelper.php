<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get image URL safely, returning null if path is empty or image doesn't exist
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
            // Try to get the URL - may throw exception if file doesn't exist on Cloudinary
            return Storage::url($path);
        } catch (\Throwable $e) {
            // Image doesn't exist on storage - return null
            // The placeholder will be shown instead
            return null;
        }
    }
}
