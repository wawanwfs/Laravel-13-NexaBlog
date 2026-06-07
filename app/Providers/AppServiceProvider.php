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
        if (request()->header('x-forwarded-proto') === 'https' || env('FORCE_HTTPS') === true || env('FORCE_HTTPS') === 'true') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
