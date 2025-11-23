<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that offers a solution to a web application's entire image
    | management pipeline.
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    /**
     * Upload Preset
     */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /**
     * Cloudinary Notification URL
     */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /**
     * Cloudinary Secure URL
     */
    'secure_url' => env('CLOUDINARY_SECURE_URL', true),
];
