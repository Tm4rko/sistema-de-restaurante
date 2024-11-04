<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $productos = Producto::where('categoria_id', '!=', 7)->get();
        return view('index', compact('productos'));
    }

    public function listaProductos(){
        $categorias = Categoria::all();
        $guarnicionesCategoria = Categoria::where('nombre', 'Guarniciones')->first();
        $guarniciones = Producto::where('categoria_id', $guarnicionesCategoria->id)->get();
        return view('listaProductos', compact('categorias', 'guarniciones'));
    }
}
