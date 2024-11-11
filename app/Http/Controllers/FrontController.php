<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->hasRole('Cliente')) {
            if (!Session::has('sucursal_id')) {
                return redirect()->route('cliente.select_sucursal.form');
            }
        }
        $productos = Producto::where('categoria_id', '!=', 7)->get();
        $sucursales = Sucursal::all();

        // Obtener la sucursal seleccionada de la sesión 
        $sucursalSeleccionada = null;
        if (session()->has('sucursal_id')) {
            $sucursalSeleccionada = Sucursal::find(session('sucursal_id'));
        }
        // Asegúrate de obtener las sucursales 
        return view('index', compact('productos', 'sucursales', 'sucursalSeleccionada'));
    }

    public function listaProductos()
    {
        $categoriasExcluidas = ['Bebidas', 'Postres', 'Guarniciones'];
        $categorias = Categoria::whereNotIn('nombre', $categoriasExcluidas)->get();

        $guarnicionesCategoria = Categoria::where('nombre', 'Guarniciones')->first();
        $guarniciones = Producto::where('categoria_id', $guarnicionesCategoria->id)->get();

        $guarnicionesCategoria = Categoria::where('nombre', 'Guarniciones')->first();
        $guarniciones = Producto::where('categoria_id', $guarnicionesCategoria->id)->get();

        $categoriasIncluidas = ['Guarniciones', 'Postres', 'Bebidas'];
        $categoriasNoCarnes = Categoria::whereIn('nombre', $categoriasIncluidas)->get();

        $sucursales = Sucursal::all();

        // Obtener la sucursal seleccionada de la sesión 
        $sucursalSeleccionada = null;
        $stocks = [];
        if (session()->has('sucursal_id')) {
            $sucursalSeleccionada = Sucursal::find(session('sucursal_id'));
            // Obtener el stock de cada producto en la sucursal seleccionada
            $stocks = \DB::table('stock_sucursales')
                ->where('sucursal_id', $sucursalSeleccionada->id)
                ->pluck('stock', 'producto_id');
        }

        return view('listaProductos', compact('categorias', 'guarniciones', 'categoriasNoCarnes', 'sucursales', 'sucursalSeleccionada', 'stocks'));
    }
}
