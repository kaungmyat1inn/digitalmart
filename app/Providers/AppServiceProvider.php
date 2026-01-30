<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
    // Production ရောက်ရင် HTTPS အတင်းသုံးခိုင်းခြင်း
    if($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
}
