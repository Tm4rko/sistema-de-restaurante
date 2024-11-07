<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(){
        $pedidos = Pedido::orderByDesc("updated_at")->get();
        return view('admin.pedido.index', compact('pedidos'));
    }
}
