<?php

namespace App\Providers;

use App\Models\Pedido;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('adminlte::partials.navbar.menu-item-dropdown-user-menu', function ($view) {
            $pedidosNuevosCount = Pedido::where('estado', 'Nuevo')->count();
            $view->with('pedidosNuevosCount', $pedidosNuevosCount);
        });
    }
}
