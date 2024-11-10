<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index(){
        $sucursal_id = Auth::user()->sucursal_id;

        $pedidos = Pedido::with('user')
        ->where('sucursal_id', $sucursal_id)
        ->orderByDesc("updated_at")
        ->get();
        
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function edit($id){
        $pedido = Pedido::find($id);
        return view('admin.pedidos.edit', compact('pedido'));
    }

    
}
