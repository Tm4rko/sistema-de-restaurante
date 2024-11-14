<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $sucursal_id = Auth::user()->sucursal_id;
        // Obtener pedidos en estado "Nuevo" o "Proceso" 
        $pedidosActivos = Pedido::with('user')
            ->where('sucursal_id', $sucursal_id)
            ->whereIn('estado', ['Nuevo', 'Proceso'])
            ->orderBy('created_at', 'asc')
            ->get();
        // Obtener pedidos en estado "Completado" 
        $pedidosCompletados = Pedido::with('user')
            ->where('sucursal_id', $sucursal_id)
            ->where('estado', 'Completado')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.pedidos.index', compact('pedidosActivos', 'pedidosCompletados'));
    }

    public function edit($id)
    {
        $pedido = Pedido::find($id);
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->fill($request->all());
        $pedido->save();
        return redirect()->route('admin.pedidos.index')
            ->with('mensaje', 'Pedido actualizado correctamente')
            ->with('icono', 'success');
    }
}
