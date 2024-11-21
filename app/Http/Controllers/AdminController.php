<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){
        $total_categorias = Categoria::count();
        $total_roles = Role::count();
        $total_usuarios = User::count();
        $total_productos = Producto::count();

        $sucursal_id = Auth::check() ? Auth::user()->sucursal_id : redirect()->route('login')->send();
        $sucursal = Sucursal::where('id', $sucursal_id)->first();

        // Contar los pedidos nuevos 
        $pedidosNuevosCount = Pedido::where('estado', 'Nuevo')->count();
        return view('admin.index', compact('sucursal', 'total_roles', 'total_usuarios',
         'total_categorias', 'total_productos', 'pedidosNuevosCount'));
    }
}
