<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Foundation\TelsListHandler;
use App\Http\Controllers\Foundation\TelMemberHandler;
use App\Http\Controllers\Foundation\TelEventHandler;

use App\Http\Controllers\Foundation\SmallTelDateHandler;
use App\Http\Controllers\Foundation\UISupporter;

use App\Http\Controllers\Foundation\UserHandler;
use App\Http\Controllers\Foundation\OfficeHandler;
use App\Http\Controllers\Foundation\OfficeAccountHandler;
use App\Http\Controllers\Foundation\OfficeTodoHandler;
use App\Http\Controllers\Foundation\OfficeRoomHandler;
use App\Http\Controllers\Foundation\OfficeTenantHandler;



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
        $this->app->singleton('TelsListHandler', function () {
            return new TelsListHandler;
        });
        $this->app->singleton('TelMemberHandler', function () {
            return new TelMemberHandler;
        });
        $this->app->singleton('TelEventHandler', function () {
            return new TelEventHandler;
        });

        $this->app->singleton('SmallTelDateHandler', function () {
            return new SmallTelDateHandler;
        });


        $this->app->singleton('OfficeHandler', function () {
            return new OfficeHandler;
        });
        $this->app->singleton('UserHandler', function () {
            return new UserHandler;
        });
        $this->app->singleton('OfficeAccountHandler', function () {
            return new OfficeAccountHandler;
        });
        $this->app->singleton('OfficeTodoHandler', function () {
            return new OfficeTodoHandler;
        });
        $this->app->singleton('OfficeRoomHandler', function () {
            return new OfficeRoomHandler;
        });
        $this->app->singleton('OfficeTenantHandler', function () {
            return new OfficeTenantHandler;
        });
    }
}
