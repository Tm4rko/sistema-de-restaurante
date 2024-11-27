<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function categorias(){
        $categorias = Categoria::all();
        return response()->json($categorias, 200);
    }

    public function productos(Request $request){
        $productos = Producto::whereCategoria_id($request->categoria_id)->get();
        return response()->json($productos, 200);
    }
}
