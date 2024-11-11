<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rutas para las vistas del cliente
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('index');

Route::get('/listaProductos', [FrontController::class, 'listaProductos'])->name('listaProductos');

Auth::routes();
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

/*Route::group(['middleware' => ['auth', 'no-cache', 'role:Administrador']], function () {});

Route::group(['middleware' => ['auth', 'role:Cliente']], function () {
    //Route::get('/index', [\App\Http\Controllers\FrontController::class, 'index'])->name('index');
    // Rutas para clientes 
    Route::get('/cliente/select-sucursal', [ClienteController::class, 'showSelectSucursalForm'])->name('cliente.select_sucursal.form');
    Route::post('/cliente/select-sucursal', [ClienteController::class, 'selectSucursal'])->name('cliente.sucursal.select');
});*/


// Rutas protegidas por autenticación y roles 
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
        Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

        //Rutas para usuarios
        Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index');
        Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create');
        Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store');
        Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show');
        Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
        Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update');
        Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');

        //Rutas para categorias
        Route::get('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('admin.categorias.index');
        Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('admin.categorias.create');
        Route::post('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'store'])->name('admin.categorias.store');
        Route::get('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('admin.categorias.show');
        Route::get('/admin/categorias/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('admin.categorias.edit');
        Route::put('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('admin.categorias.update');
        Route::delete('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

        //Rutas para roles
        Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show');
        Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy');

        //Rutas para productos
        Route::get('/admin/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('admin.productos.index');
        Route::get('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('admin.productos.create');
        Route::post('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'store'])->name('admin.productos.store');
        Route::get('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('admin.productos.show');
        Route::get('/admin/productos/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('admin.productos.edit');
        Route::put('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('admin.productos.update');
        Route::delete('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('admin.productos.destroy');

        //Rutas para las sucursales
        Route::get('/crear-sucursal', [App\Http\Controllers\SucursalController::class, 'create'])->name('admin.sucursals.create');
        Route::post('/crear-sucursal/create', [App\Http\Controllers\SucursalController::class, 'store'])->name('admin.sucursals.store');
        //Rutas para configuraciones
        Route::get('/admin/configuracion', [App\Http\Controllers\SucursalController::class, 'edit'])->name('admin.configuracion.edit');
        Route::put('/admin/configuracion/{id}', [App\Http\Controllers\SucursalController::class, 'update'])->name('admin.configuracion.update');

        //Rutas para los pedidos
        Route::get('/admin/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/admin/pedidos/{id}/edit', [App\Http\Controllers\PedidoController::class, 'edit'])->name('admin.pedidos.edit');
        Route::put('/admin/pedidos/{id}', [App\Http\Controllers\PedidoController::class, 'update'])->name('admin.pedidos.update');

        //Ruta para los stocks
        Route::get('/admin/stocks', [StockController::class, 'index'])->name('admin.stocks.index');
        Route::put('/admin/stocks/{productoId}', [StockController::class, 'updateStock'])->name('admin.stocks.update');
    });

    // Rutas para Clientes 
    Route::group(['middleware' => ['role:Cliente']], function () {
        Route::get('/cliente/select-sucursal', [ClienteController::class, 'showSelectSucursalForm'])->name('cliente.select_sucursal.form');
        Route::post('/cliente/select-sucursal', [ClienteController::class, 'selectSucursal'])->name('cliente.sucursal.select');
    });
});
