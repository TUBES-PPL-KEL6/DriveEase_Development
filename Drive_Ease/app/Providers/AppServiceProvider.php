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
    public function boot()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-wRCvWdsazcsRUgc8lmoXgIoW';
        \Midtrans\Config::$isProduction = false; // true untuk real
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
}
