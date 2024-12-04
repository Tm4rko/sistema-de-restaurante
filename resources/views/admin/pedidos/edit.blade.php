@extends('adminlte::page')

@section('content_header')
<h1>Pedidos/Actualizar estado del Pedido</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">Datos del Pedido</h3>
                    </div>
                    <div class="col-md-6">
                        {!! Form::open(['route' => ['admin.pedidos.update', $pedido->id], 'method' => 'PUT']) !!}
                        <div class="row">
                            <div class="col-6">
                                @if ($pedido->id === $pedidosActivos->first()->id)
                                {!! Form::select('estado',
                                ['Nuevo' => 'Nuevo', 'Proceso' => 'Proceso', 'Completado' => 'Completado'],
                                $pedido->estado,
                                ['class' => 'form-control', 'required']
                                ) !!}
                                @else
                                {!! Form::select('estado',
                                ['Nuevo' => 'Nuevo', 'Proceso' => 'Proceso'],
                                $pedido->estado,
                                ['class' => 'form-control', 'required']
                                ) !!}
                                @endif
                            </div>
                            <div class="col-6">
                                {{ Form::submit('Actualizar', ['class' => 'btn btn-success w-100']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nombre del Cliente</label>
                                    <p>{{ $pedido->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <p>{{ $pedido->user->celular }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <p>{{ $pedido->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha del Pedido</label>
                                    <p>{{ $pedido->fechaPedido }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <p>{{ $pedido->user->direccion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <!---->
        <table id="mitabla" class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Especificaciones</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th style="text-align: right;" scope="col">Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php $contador = 1; ?>
                @forelse ($pedido->detalles as $detalle)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{$contador++}}</td>
                    <td style="vertical-align: middle;">{{$detalle->producto->nombre}}</td>
                    <td style="vertical-align: middle;">{{$detalle->especificacion}}</td>
                    <td style="vertical-align: middle;">{{$detalle->cantidad}}</td>
                    <td style="vertical-align: middle;">{{$detalle->precio}}</td>
                    <td style="vertical-align: middle; text-align: right;">{{$detalle->importe}}</td>
                </tr>
                @empty
                <tr>
                    <td></td>
                </tr>
                @endforelse
                <tr>

                    <td colspan="5">
                        <a href="{{url('/admin/pedidos')}}" class="btn btn-secondary">Volver</a>
                    </td>
                    <td colspan="3" style="text-align: right;">Total: {{$pedido->total}}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop