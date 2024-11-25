<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sucursals.create');
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
            'nombre_sucursal' => 'required',
            'nit' => 'required|digits:9',
            'telefono' => ['required', 'digits:8', 'regex:/^[67][0-9]{7}$/'],
            'correo' => 'required|unique:sucursals',
            'direccion' => 'required',
            //'logo' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $sucursal = new Sucursal();

        $sucursal->nombre_sucursal = $request->nombre_sucursal;
        $sucursal->nit = $request->nit;
        $sucursal->telefono = $request->telefono;
        $sucursal->correo = $request->correo;
        $sucursal->direccion = $request->direccion;
        $sucursal->logo = '/images/logo.png';
        $sucursal->save();

        $usuario = new User();
        $usuario->name = "Admin";
        $usuario->email = $request->correo;
        $usuario->celular = $request->telefono;
        $usuario->password = Hash::make($request['nit']);
        $usuario->sucursal_id = $sucursal->id;
        $usuario->save();

        $usuario->assignRole('Administrador');

        //Auth::login($usuario);

        //return redirect()->route('admin.index')
        return redirect()->route('home')
            ->with('mensaje', 'Se registro la sucursal de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursal $sucursal)
    {
        $sucursal_id = Auth::user()->sucursal_id;
        $sucursal = Sucursal::where('id', $sucursal_id)->first();
        return view('admin.configuraciones.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sucursal' => 'required',
            'nit' => 'required|digits:9',
            'telefono' => ['required', 'digits:8', 'regex:/^[67][0-9]{7}$/'],
            'correo' => 'required|email|unique:sucursals,correo,' . $id,
            'direccion' => 'required',
        ]);

        $sucursal = Sucursal::findOrFail($id);

        $sucursal->nombre_sucursal = $request->nombre_sucursal;
        $sucursal->nit = $request->nit;
        $sucursal->telefono = $request->telefono;
        $sucursal->correo = $request->correo;
        $sucursal->direccion = $request->direccion;

        if ($request->hasFile('logo')) {
            Storage::delete('public/' . $sucursal->logo);
            $sucursal->logo = $request->file('logo')->store('logos', 'public');
        }

        $sucursal->save();

        return redirect()->route('admin.index')
            ->with('mensaje', 'Se modificaron los datos de la sucursal de manera correcta')
            ->with('icono', 'success');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        //
    }
}
