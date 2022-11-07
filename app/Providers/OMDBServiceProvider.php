<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\OMDB;

class OMDBServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('omdb', function() {
            return new OMDB(config('omdb.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
