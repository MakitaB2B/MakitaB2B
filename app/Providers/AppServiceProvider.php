<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        // $app = base_path('constants/app.php');
        // include $app;
        foreach (glob(base_path() . "/constants/*.php") as $filename
        ) {
            include $filename;
        }
    }
}
