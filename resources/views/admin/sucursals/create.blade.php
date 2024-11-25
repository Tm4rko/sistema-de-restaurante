@extends('adminlte::page')

@section('content_header')
<h1>Sucursal/Crear sucursal</h1>
<hr>
@stop

@section('content')
<div class="container">
    <!--<center>
        <img src="{{ asset('/images/logo.png')}}" width="250px" alt="">
    </center>-->

    <div class="row">
        <div class="col-md-12">
            {{-- Card Box --}}
            <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}" style="box-shadow: 5px 0px 5px 0px #cccccc;">

                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        <b>Registro de la Sucursal</b>
                    </h3>
                </div>

                {{-- Card Body --}}
                <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                    <form action="{{url('crear-sucursal/create')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!--<div class="col-md-3">
                                <div class="form-group">
                                    <label for="logo">Logo <span style="color: red;">*</span> </label>
                                    <input type="file" name="logo" id="file" accept=".jpg, .jpeg, .png" class="form-control" required>
                                    @error('logo')
                                    <small style="color:red">{{$message}}</small>
                                    @enderror
                                    <br>
                                    <center><output id="list"></output></center>
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
                            </div>-->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="nombre_sucursal">Nombre de la Sucursal <span style="color: red;">*</span></label>
                                            <input name="nombre_sucursal" type="text" value="{{old('nombre_sucursal')}}" maxlength="50" onkeypress="soloLetras(event)" class="form-control" required>
                                            @error('nombre_sucursal')
                                            <small style="color:red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nit">NIT <span style="color: red;">*</span></label>
                                            <input name="nit" value="{{old('nit')}}" type="number" min="1" class="form-control" onkeydown="evitarPunto(event)" required>
                                            @error('nit')
                                            <small style="color:red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono de la Sucursal <span style="color: red;">*</span></label>
                                            <input name="telefono" value="{{old('telefono')}}" type="number" min="1" class="form-control" onkeydown="evitarPunto(event)" required>
                                            @error('telefono')
                                            <small style="color:red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="correo">Correo de la Sucursal <span style="color: red;">*</span></label>
                                            <input name="correo" value="{{old('correo')}}" type="email" class="form-control" required>
                                            @error('correo')
                                            <small style="color:red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="direccion">Dirección <span style="color: red;">*</span></label>
                                            <input id="pac-input" value="{{old('direccion')}}" class="form-control" name="direccion" type="text" maxlength="350" required>
                                            @error('direccion')
                                            <small style="color:red">{{$message}}</small>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-5">
                                        <div class="form-group d-flex justify-content-between">
                                            <a href="{{url('/home')}}" class="btn btn-lg btn-secondary flex-grow-1 mr-2">Cancelar</a>
                                            <button type="submit" class="btn btn-lg btn-primary flex-grow-1">Crear Sucursal</button>
                                        </div>
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
</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')



@stop