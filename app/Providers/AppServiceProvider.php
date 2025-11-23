<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::if('guestAny', function () {
            return auth('admin')->guest() && auth('web')->guest();
        });
        Blade::if('guestAndUser', function () {
            return !auth()->guard('admin')->check();
        });
        Blade::if('auth', function () {
            return auth()->guard('admin')->check() || auth()->guard('web')->check();
        });
        Blade::if('onlyUser', function () {
            return auth()->guard('web')->check();
        });
        Blade::if('onlyAdmin', function () {
            return auth()->guard('admin')->check();
        });
    }
}
