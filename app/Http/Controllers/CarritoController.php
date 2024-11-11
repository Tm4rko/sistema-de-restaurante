<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use PhpParser\Node\Expr\FuncCall;

class CarritoController extends Controller
{
    public function agregarItem(Request $request)
    {
        $producto = Producto::find($request->producto_id);

        Cart::add([
            'id' => $producto->id,
            'name' => $producto->nombre,
            'price' => $producto->precio_venta,
            'qty' => 1,
            'weight' => 1,
            'options' => [
                'imagen' => $producto->imagen,
                'nombre' => null,
            ]
        ]);

        return redirect()->back()->with("success", "$producto->nombre !Se agregó correctamente al carrito");
    }

    public function verCarrito()
    {
        $sucursales = Sucursal::all(); // Obtener la sucursal seleccionada de la sesión
        $sucursalSeleccionada = null;
        if (session()->has('sucursal_id')) {
            $sucursalSeleccionada = Sucursal::find(session('sucursal_id'));
        }
        return view('carrito', compact('sucursales', 'sucursalSeleccionada'));
    }

    public function eliminarItem(Request $request)
    {
        Cart::remove($request->id);
        return redirect()->back()->with("success", "Eliminado correctamente");
    }

    public function eliminarCarrito()
    {
        Cart::destroy();
        return redirect()->back()->with("success", "Carrito eliminado correctamente!");
    }

    public function confirmarCarrito()
    {
        $pedido = new Pedido();
        $pedido->total = Cart::total();
        $pedido->fechaPedido = date("Y-m-d h:m:s");
        $pedido->procedencia = "Web";
        $pedido->estado = "Nuevo";
        $pedido->comentario = "comentario de prueba";
        $pedido->user_id = auth()->user()->id;

        // Obtener la sucursal seleccionada de la sesión 
        if (session()->has('sucursal_id')) {
            $pedido->sucursal_id = session('sucursal_id');
        } else {
            // Manejar el caso en que no haya sucursal seleccionada 
            return redirect()->back()
                ->with('error', 'Debe seleccionar una sucursal antes de confirmar el pedido.');
        }

        $pedido->save();

        foreach (Cart::content() as $item) {
            $detalle = new Detalle();

            $detalle->precio = $item->price;
            $detalle->cantidad = $item->qty;
            $detalle->importe = $item->price * $item->qty;
            $detalle->especificacion = "especificacion de prueba";
            $detalle->producto_id = $item->id;
            $detalle->pedido_id = $pedido->id;

            $detalle->save();
        }

        Cart::destroy();
        return redirect()->back()->with("success", "¡Tu pedido ha sido registrado con éxito!");
    }
}
