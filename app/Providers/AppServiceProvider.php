<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        View::composer('components.header', function ($view) {
            $cart = session('cart', []);
            // Count total quantities, not unique items
            $cartCount = collect($cart)->sum('quantity');
            $view->with('cartCount', $cartCount);
        });
    }
}

