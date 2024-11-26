<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursal_id = Auth::user()->sucursal_id;
        $usuarios = User::where('sucursal_id', $sucursal_id)->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
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
            'name' => ['required', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => 'required|unique:users',
            'celular' => ['required', 'digits:8', 'regex:/^[67][0-9]{7}$/'],
            'direccion' => ['required', 'max:350'],
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
        ]);

        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->celular = $request->celular;
        $usuario->direccion = $request->direccion;
        $usuario->password = Hash::make($request->password);
        $usuario->sucursal_id = Auth::user()->sucursal_id;

        $usuario->save();

        $usuario->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Se registro al usuario de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $usuario = User::findOrFail($id);
            return view('admin.usuarios.show', compact('usuario'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'El usuario no fue encontrado o ha sido eliminado')
                ->with('icono', 'error');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $roles = Role::all();
            return view('admin.usuarios.edit', compact('usuario', 'roles'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'El usuario no fue encontrado o ha sido eliminado')
                ->with('icono', 'error');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$datos = $request->all();
        //return response()->json($datos);

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => 'required|unique:users,email,' . $id,
            'celular' => ['required', 'digits:8', 'regex:/^[67][0-9]{7}$/'],
            'direccion' => ['required', 'max:350'],
            'password' => ['string', 'min:8', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
        ]);

        $usuario = User::find($id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->celular = $request->celular;
        $usuario->direccion = $request->direccion;
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->sucursal_id = Auth::user()->sucursal_id;

        $usuario->save();

        $usuario->syncRoles($request->role);

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Se modifico al usuario de manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {
        $user = User::find($id);

        if (Auth::user()->id == $user->id) {
            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'No puedes eliminar tu propia cuenta.')
                ->with('icono', 'error');
        }

        try {
            // Eliminar roles asociados del usuario
            $user->syncRoles([]);

            // Intentar eliminar el usuario
            $user->delete();

            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'Se eliminó el usuario de manera correcta')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'No se puede eliminar el usuario porque tiene registros asociados.')
                ->with('title', '')
                ->with('icono', 'error');
        }
    }*/
    public function destroy($id)
    {
        $user = User::find($id);
        Log::info('Intentando eliminar usuario', ['user_id' => $user->id]);

        if (Auth::user()->id == $user->id) {
            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'No puedes eliminar tu propia cuenta.')
                ->with('icono', 'error');
        }

        DB::beginTransaction();
        try {
            Log::info('Eliminando roles del usuario', ['user_id' => $user->id]);
            $user->syncRoles([]);

            Log::info('Roles eliminados, intentando eliminar usuario', ['user_id' => $user->id]);
            $user->delete();

            DB::commit();
            Log::info('Usuario eliminado con éxito', ['user_id' => $user->id]);

            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'Se eliminó el usuario de manera correcta')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar el usuario', ['error' => $e->getMessage()]);

            return redirect()->route('admin.usuarios.index')
                ->with('mensaje', 'No se puede eliminar el usuario porque tiene registros asociados.')
                ->with('title', '')
                ->with('icono', 'error');
        }
    }
}
