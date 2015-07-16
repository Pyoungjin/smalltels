<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Foundation\Tels_listCtr;
use App\Http\Controllers\Foundation\Tels_staffCtr;
use App\Http\Controllers\Foundation\Tels_eventCtr;


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
        // $this->app->bind('Tels_list',function () {
        //     return new Tels_listCtr;
        // });
        // $this->app->bind('Tels_staff',function () {
        //     return new Tels_staffCtr;
        // });
        $this->app->bind('Tels_event',function () {
            return new Tels_eventCtr;
        });
    }
}
