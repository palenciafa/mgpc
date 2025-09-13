<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Make low-stock products available in all views
        View::composer('*', function ($view) {
            $lowStockProducts = Product::where('stock', '<', 100)->get();
            $lowStockCount = $lowStockProducts->count();

            $view->with(compact('lowStockProducts', 'lowStockCount'));
        });
    }
}
