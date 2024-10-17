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
        $productos = Producto::with('categoria')->get();
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
            'nombre'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
        ]);

        $producto = new Producto();

        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        if($request->hasFile('imagen')){
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();
        
        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se registro el producto de manera correcta')
            ->with('icono','success');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
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
            'nombre'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
        ]);

        $producto = Producto::find($id);

        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        if($request->hasFile('imagen')){
            Storage::delete('public/'.$producto->imagen);
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();
        
        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se actualizo el producto de manera correcta')
            ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        Producto::destroy($id);
        Storage::delete('public/'.$producto->imagen);

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se elimino el producto de manera correcta')
            ->with('icono', 'success');
    }
}
