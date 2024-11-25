<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$datos = $request->all();
        //return response()->json($datos);

        $request->validate([
            'nombre' => 'required',
            'precio_venta' => 'required|numeric|min:1',

        ]);

        $producto = new Producto();

        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = (new \DateTime())->format('Y-m-d');
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se registro el producto de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            return view('admin.productos.show', compact('producto'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.productos.index')
                ->with('mensaje', 'El producto no fue encontrado o ha sido eliminado')
                ->with('icono', 'error');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $categorias = Categoria::all();
            return view('admin.productos.edit', compact('producto', 'categorias'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.productos.index')
                ->with('mensaje', 'El producto no fue encontrado o ha sido eliminado')
                ->with('icono', 'error');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$datos = $request->all();
        //return response()->json($datos);

        $request->validate([
            'nombre' => 'required',
            'precio_venta' => 'required|numeric|min:1',
        ]);

        $producto = Producto::find($id);

        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = (new \DateTime())->format('Y-m-d');
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            Storage::delete('public/' . $producto->imagen);
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se actualizo el producto de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Encontrar el producto
            $producto = Producto::findOrFail($id);

            // Eliminar el producto
            Producto::destroy($id);

            // Eliminar la imagen asociada del almacenamiento
            Storage::delete('public/' . $producto->imagen);

            // Redirigir con un mensaje de éxito
            return redirect()->route('admin.productos.index')
                ->with('mensaje', 'Se eliminó el producto de manera correcta')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            // Capturar y manejar cualquier excepción
            \Log::error('Error al eliminar el producto: ' . $e->getMessage());

            // Redirigir con un mensaje de error
            return redirect()->route('admin.productos.index')
                ->with('mensaje', 'No se puede eliminar el producto porque tiene registros asociados.')
                ->with('icono', 'error');
        }
    }
}
