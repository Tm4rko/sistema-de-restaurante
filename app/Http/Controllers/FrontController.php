<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $productos = Producto::where('categoria_id', '!=', 7)->get();
        return view('index', compact('productos'));
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

        return view('listaProductos', compact('categorias', 'guarniciones', 'categoriasNoCarnes'));
    }
}
