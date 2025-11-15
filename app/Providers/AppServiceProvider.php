<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;  
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Models\Cart;
use Auth;

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
        View::composer('layouts.*', function ($view) {
            $cartCount = 0;

            if (Auth::guard('admin')->check()) {
                $order = Order::count() + 1;
                $invoice = Carbon::now()->format('Ymd').Auth::guard('admin')->id().$order;
                $cartCount = Cart::where('reg', $invoice)->count();
            }

            $view->with([
                'cartCount' => $cartCount
            ]);
        });
    }
}
