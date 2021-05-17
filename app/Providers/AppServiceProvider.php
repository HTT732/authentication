<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Cookie::has('remmeber_token')) {
            View::share('remmeber_token', 'remmeber_token');
        }

   }
}
