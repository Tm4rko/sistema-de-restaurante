<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categorias.create');
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
            'nombre' => 'required|unique:categorias|max:50',
            'descripcion' => 'required|max:200',
        ]);

        $categoriasExistentes = Categoria::all()->pluck('nombre')->toArray();

        function esSimilar($nuevaCategoria, $categoriasExistentes, $umbral = 85)
        {
            foreach ($categoriasExistentes as $categoria) {
                similar_text(strtolower($nuevaCategoria), strtolower($categoria), $porcentaje);
                if ($porcentaje > $umbral) {
                    return true;
                }
            }
            return false;
        }

        if (esSimilar($request->nombre, $categoriasExistentes)) {
            return
                redirect()->back()
                ->withErrors(['nombre' => 'El nombre de la categoría es demasiado similar a una existente.'])
                ->withInput();
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->route('admin.categorias.index')
            ->with('mensaje', 'Se registró la categoría de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            return view('admin.categorias.show', compact('categoria'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.categorias.index')
                ->with('mensaje', 'La categoría no fue encontrada o ha sido eliminada')
                ->with('icono', 'error');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            return view('admin.categorias.edit', compact('categoria'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.categorias.index')
                ->with('mensaje', 'La categoría no fue encontrada o ha sido eliminada')
                ->with('icono', 'error');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$datos = $request->all();
        //return response()->json($datos);

        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $id . '|max:50',
            'descripcion' => 'required|max:200',
        ]);

        $categoria = Categoria::find($id);

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        $categoria->save();

        return redirect()->route('admin.categorias.index')
            ->with('mensaje', 'Se modifico la categoria de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Intentar eliminar la categoría
            Categoria::destroy($id);

            return redirect()->route('admin.categorias.index')
                ->with('mensaje', 'Se eliminó la categoría de manera correcta')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            // Si ocurre un error al eliminar (por restricciones de clave externa), capturar la excepción
            return redirect()->route('admin.categorias.index')
                ->with('mensaje', 'No se puede eliminar la categoría porque tiene registros asociados.')
                ->with('title', '')
                ->with('icono', 'error');
        }
    }
}
