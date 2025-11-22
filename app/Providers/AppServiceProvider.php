<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Railway deployment)
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        // Share active flash sale status with navbar
        view()->composer('layouts.app', \App\View\Composers\NavbarComposer::class);
    }
}
