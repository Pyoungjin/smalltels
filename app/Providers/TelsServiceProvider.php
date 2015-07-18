<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Foundation\Tels_listCtr;
use App\Http\Controllers\Foundation\Tels_staffCtr;
use App\Http\Controllers\Foundation\Tels_eventCtr;
use App\Http\Controllers\Foundation\OfficeHandler;


class TelsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Tels_listCtr',function () {
            return new Tels_listCtr;
        });
        $this->app->singleton('Tels_staffCtr',function () {
            return new Tels_staffCtr;
        });
        $this->app->singleton('Tels_eventCtr',function () {
            return new Tels_eventCtr;
        });
        $this->app->singleton('OfficeHandler',function () {
            return new OfficeHandler;
        });
    }
}
