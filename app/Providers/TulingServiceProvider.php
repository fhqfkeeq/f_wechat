<?php

namespace App\Providers;

use App\Repositories\Tuling;
use Illuminate\Support\ServiceProvider;

class TulingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('Tuling',Tuling::class);
    }
}
