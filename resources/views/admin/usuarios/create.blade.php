@extends('adminlte::page')


@section('content_header')
<h1>Usuarios/Registro de un nuevo Usuario</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
            </div>

            <div class="card-body">
                <form action="{{url('/admin/usuarios/create')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role">Nombre del Rol <span style="color: red;">*</span></label>
                                <select name="role" id="" class="form-control">
                                    @foreach ($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre del Usuario <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" value="{{old('name')}}" name="name" maxlength="70" onkeydown="return soloLetras(event)" required>
                                @error('name')
                                <small style="color:red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email <span style="color: red;">*</span></label>
                                <input type="email" class="form-control" value="{{old('email')}}" name="email" required>
                                @error('email')
                                <small style="color:red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular">Celular <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" value="{{old('celular')}}" onkeydown="evitarPunto(event)" name="celular" required>
                                @error('celular')
                                <small style="color:red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password <span style="color: red;">*</span></label>
                                <input type="password" class="form-control" value="{{old('password')}}" name="password" required>
                                @error('password')
                                <small style="color:red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Password <span style="color: red;">*</span></label>
                                <input type="password" class="form-control" value="{{old('password_confirmation')}}" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('/admin/usuarios')}}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop