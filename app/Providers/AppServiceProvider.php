<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Jareer(implement befor migrating the database)
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // Jareer(setup the stringlength to 191 )
        Schema::defaultStringLength(191);
    }
}
