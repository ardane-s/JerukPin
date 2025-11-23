<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get image URL safely, returning null if path is empty
     * Browser will handle 404s via img onerror handler
     * 
     * @param string|null $path
     * @return string|null
     */
    public static function getImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Just return the URL directly - let the browser handle 404s
        // This avoids slow exception handling or API calls
        return Storage::url($path);
    }
}
