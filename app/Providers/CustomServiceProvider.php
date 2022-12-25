<?php

namespace App\Providers;

use App\ContactQuery;
use App\Observers\ContactObserver;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      ContactQuery::observe(ContactObserver::class);
    }
}
