<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // Redirigir a la vista de login después de logout
    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function redirectPath()
    {
        /*if(auth()->user()->hasRole("Cliente")){
            return "/index";
        }
        return "/home";*/

        $user = auth()->user();

        if ($user->hasRole("Cliente")) {
            return route('cliente.select_sucursal.form');
        } elseif ($user->hasRole("Administrador")) {
            return route('home'); // o la ruta correspondiente para administradores 
        }
        return route('index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
