<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class LaravelLoggerProxy {
    public function log( $msg ) {
        Log::info($msg);
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        $pusher = $this->app->make('pusher');
        $pusher->set_logger( new LaravelLoggerProxy() );
         Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
