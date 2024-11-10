@extends('adminlte::page')

@section('content_header')
<h1>Pedidos/Listado de Pedidos</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Productos Registrados</h3>
                <div class="card-tools">
                    <a href="{{url('/admin/productos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mitabla" class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="text-align: center;">Nro</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Fecha-Hora Pedido</th>
                                <th scope="col">Procedencia</th>
                                <th scope="col">Total</th>
                                <th scope="col">Estado</th>
                                <th scope="col" style="text-align: center;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            @forelse ($pedidos as $pedido)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">{{$contador++}}</td>
                                <td style="vertical-align: middle;">{{$pedido->user->name}}</td>
                                <td style="vertical-align: middle;">{{$pedido->fechaPedido}}</td>
                                <td style="vertical-align: middle;">{{$pedido->procedencia}}</td>
                                <td style="text-align: center; vertical-align: middle;">{{$pedido->total}}</td>
                                <td style="vertical-align: middle;">{{$pedido->estado}}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/pedidos/'.$pedido->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
<script>
    $('#mitabla').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
            "infoFiltered": "(Filtrado de _MAX_ total Productos)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Productos",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscador:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
</script>
@stop