@extends('adminlte::page')


@section('content_header')
<h1>Configuraciones/Editar</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- Card Box --}}
        <div class="card card-outline card-success" style="box-shadow: 5px 0px 5px 0px #cccccc;">


            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                <h3 class="card-title float-none">
                    <b>Datos Registrados</b>
                </h3>
            </div>

            {{-- Card Body --}}
            <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                <form action="{{url('/admin/configuracion',$sucursal->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="file" accept=".jpg, .jpeg, .png" class="form-control">
                                @error('logo')
                                <small style="color:red">{{$message}}</small>
                                @enderror
                                <br>
                                <center>
                                    <output id="list">
                                        <img src="{{asset('storage/'.$sucursal->logo)}}" width="80%" alt="logo">
                                    </output>
                                </center>
                                <script>
                                    function archivo(evt) {
                                        var files = evt.target.files; //file List objet
                                        //Obtenemos la imagen del campo "file"
                                        for (var i = 0, f; f = files[i]; i++) {
                                            //solo admitimos imagenes
                                            if (!f.type.match('image.*')) {
                                                continue;
                                            }
                                            var reader = new FileReader();
                                            reader.onload = (function(theFile) {
                                                return function(e) {
                                                    //insertamos la imagen
                                                    document.getElementById("list").innerHTML = ['<img class="thumb thumbail" src="', e.target.result, '" width="70%" title="', escape(theFile.name), '"/>'].join('');
                                                };
                                            })(f);
                                            reader.readAsDataURL(f);

                                        }

                                    }
                                    document.getElementById('file').addEventListener('change', archivo, false);
                                </script>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nombre_sucursal">Nombre de la Sucursal</label>
                                        <input name="nombre_sucursal" type="text" value="{{$sucursal->nombre_sucursal}}" class="form-control" required>
                                        @error('nombre_sucursal')
                                        <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nit">NIT</label>
                                        <input name="nit" value="{{$sucursal->nit}}" type="number" min="1" class="form-control" required>
                                        @error('nit')
                                        <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono de la Sucursal</label>
                                        <input name="telefono" value="{{$sucursal->telefono}}" type="number" min="1" class="form-control" required>
                                        @error('telefono')
                                        <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="correo">Correo de la Sucursal</label>
                                        <input name="correo" value="{{$sucursal->correo}}" type="email" class="form-control" required>
                                        @error('correo')
                                        <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <input id="pac-input" value="{{$sucursal->direccion}}" class="form-control" name="direccion" type="text" required>
                                        @error('direccion')
                                        <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success btn-block">Actualizar Datos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                @yield('auth_footer')
            </div>
            @endif

        </div>
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop