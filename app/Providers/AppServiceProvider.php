<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App;

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

        $environment = App::environment();

        if ($environment != "production") {
            $environment = "local";
        }

        foreach (glob(base_path() . "/constants/" . $environment . "/*.php") as $filename) {

            include $filename;
        }
        
    }
}
