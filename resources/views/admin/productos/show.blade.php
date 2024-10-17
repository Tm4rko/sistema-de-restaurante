@extends('adminlte::page')


@section('content_header')
<h1>Productos/Datos del Producto</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Datos Registrados</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoria_id">Categoria</label>
                                    <p>{{$producto->categoria->nombre}}</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Producto</label>
                                    <p>{{$producto->nombre}}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="precio_venta">Precio de Venta</label>
                                    <p>{{$producto->precio_venta}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                                    <p>{{$producto->fecha_ingreso}}</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <p>{{$producto->descripcion}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="text-align: center;" class="form-group">
                            <label for="logo">Imagen del Producto</label><br>
                            <img  src="{{asset('storage/'.$producto->imagen)}}" width="80px" alt="imagen">
                        </div>
                    </div>
                </div>



                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{url('/admin/productos')}}" class="btn btn-secondary">Volver</a>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop