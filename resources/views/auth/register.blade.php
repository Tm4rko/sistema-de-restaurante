@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))
<!-- Scripts comunes --> 
<script src="{{ asset('js/scripts.js') }}"></script>

@section('auth_body')
<form action="{{ $register_url }}" method="post">
    @csrf

    {{-- Name field --}}
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" onkeypress="soloLetras(event)" autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Email field --}}
    <div class="input-group mb-3">
        <input type="email" name="email" onkeypress="validarEmail(event)" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Celular field --}}
    <div class="input-group mb-3">
        <input type="tel" name="celular" class="form-control @error('celular') is-invalid @enderror"
            value="{{ old('celular') }}" onkeypress="return soloNumeros(event)" placeholder="Celular" required
            inputmode="numeric" pattern="[0-9]{8}">
        <div class="input-group-append">
            <div class="input-group-text"> <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span> </div>
        </div> @error('celular') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
    </div>

    {{-- Dirección field --}}
    <div class="input-group mb-3"> <input type="text" name="direccion"
            class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}"
            placeholder="Dirección" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-map-marker-alt {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div> @error('direccion') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
    </div>

    {{-- Password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password" onkeypress="bloquearEspacios(event)" class="form-control @error('password') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.password') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Confirm password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password_confirmation" onkeypress="bloquearEspacios(event)"
            class="form-control @error('password_confirmation') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.retype_password') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Register button --}}
    <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
        <span class="fas fa-user-plus"></span>
        {{ __('adminlte::adminlte.register') }}
    </button>

</form>
@stop

@section('auth_footer')
<p class="my-0">
    <a href="{{ $login_url }}">
        {{ __('adminlte::adminlte.i_already_have_a_membership') }}
    </a>
</p>
<p class="my-0"> <a href="{{ route('index') }}" id="id-volver-registro"> {{ __('Volver a la página principal') }} </a> </p>
@stop