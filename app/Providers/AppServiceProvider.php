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
            $admin = auth()->user();
            $sucursalId = $admin->sucursal_id;
            $pedidosNuevosCount = Pedido::where('estado', 'Nuevo')->where('sucursal_id', $sucursalId)->count();
            $view->with('pedidosNuevosCount', $pedidosNuevosCount);
        });
    }
}
