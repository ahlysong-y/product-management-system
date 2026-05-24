<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider; // <-- កុំភ្លេចលួចថែមជួរនេះ

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
        // បង្ខំឱ្យប្រើ HTTPS ប្រសិនបើនៅលើម៉ាស៊ីន Render (Production)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
