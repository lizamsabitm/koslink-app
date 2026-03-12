<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Di sinilah Laravel membaca URL rahasia dari file .env
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),
    
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
];