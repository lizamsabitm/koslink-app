<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Kita tambahkan baris ini biar kenal URL

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 2. Kode paksa HTTPS ditaruh di sini:
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
