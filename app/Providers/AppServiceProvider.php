<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    // In App\Providers\AppServiceProvider.php or a dedicated service provider


    public function boot()
    {
        View::composer(
            ['layouts.navigation', 'dashboard'], // List all views where you need the variable
            function ($view) {
                // Fetch search term from request or other source
                $search = request()->input('search', '');
                $view->with('search', $search);
            }
        );
    }
}
