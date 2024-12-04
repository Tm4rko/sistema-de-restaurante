<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Pedido;
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

    // Método ajustado para obtener solo los pedidos de un usuario 4
    public function pedidos(Request $request){ 
        $userId = $request->user()->id; 
        $pedidos = Pedido::where('user_id', $userId)->get(); 
        return response()->json($pedidos, 200);
     }
}
