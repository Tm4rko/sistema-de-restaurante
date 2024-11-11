<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    // Método para mostrar la vista del stock 
    public function index()
    {
        $user = Auth::user();
        $sucursal = $user->sucursal;
        $productos = $sucursal->productos;

        //dd($sucursal, $productos); // Agregar esto para depuración

        return view('admin.stocks.index', compact('sucursal', 'productos'));
    }

    public function updateStock(Request $request, $productoId)
    {
        // Método para actualizar el stock y la disponibilidad
        $user = Auth::user();
        $sucursal = $user->sucursal;
        // Validar el stock y la disponibilidad 
        $request->validate([
            'stock' => 'required|integer|min:0',
            'disponibilidad' => 'required|boolean',
        ]);
        // Actualizar el stock y la disponibilidad 
        $sucursal->productos()->updateExistingPivot($productoId, [
            'stock' => $request->stock,
            'disponibilidad' => $request->disponibilidad,
        ]);

        return redirect()->route('admin.stocks.index')
            ->with('mensaje', 'Stock actualizado correctamente.')
            ->with('icono', 'success');
    }
}
