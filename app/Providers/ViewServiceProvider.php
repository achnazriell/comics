<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    // /**
    //  * Register any application services.
    //  *
    //  * @return void
    //  */
    public function register()
    {
        //
    }

    // /**
    //  * Bootstrap any application services.
    //  *
    //  * @return void
    //  */
    public function boot()
    {
        // // This should work if the 'view' facade is available
        // View::composer('*', function ($view) {
        //     $query = request()->input('query', '');
        //     $view->with('query', $query);
        // });
    }
}
