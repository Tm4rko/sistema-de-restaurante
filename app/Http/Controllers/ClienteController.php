<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function showSelectSucursalForm()
    {
        $sucursales = Sucursal::all();
        $productos = Producto::all();
        session(['showSucursalModal' => true]); // Almacena en la sesión
        return view('index', compact('sucursales', 'productos'));
    }
    public function selectSucursal(Request $request)
    {
        $request->validate(['sucursal_id' => 'required|exists:sucursals,id',]); // Guardar la sucursal seleccionada en la sesión 
        session(['sucursal_id' => $request->sucursal_id]);
        session()->forget('showSucursalModal'); // Limpia la sesión aquí
        return redirect()->route('index');
    }
}
