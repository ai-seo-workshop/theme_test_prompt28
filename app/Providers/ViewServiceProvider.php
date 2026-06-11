<?php

namespace App\Providers;

use App\Services\CategoryService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('categories', CategoryService::getActiveCategories());
        });
    }
}
