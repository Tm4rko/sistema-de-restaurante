@extends('adminlte::page')


@section('content_header')
<h1>Listado de Usuarios</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Usuarios Registrados</h3>
                <div class="card-tools">
                    <a href="{{url('/admin/usuarios/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                </div>
            </div>

            <div class="card-body">
                <table id="mitabla" class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center;">Nro</th>
                            <th scope="col">Rol del Usuario</th>
                            <th scope="col">Nombre del Usuario</th>
                            <th scope="col">Email</th>
                            <th scope="col" style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td style="text-align: center;">{{$contador++}}</td>
                            <td>{{$usuario->roles->pluck('name')->implode(', ')}}</td>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->email}}</td>
                            <td style="text-align: center;">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{url('/admin/usuarios',$usuario->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{url('/admin/usuarios/'.$usuario->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                    <form action="{{url('/admin/usuarios',$usuario->id)}}" method="post" onclick="preguntar{{$usuario->id}}(event)" id="miformulario{{$usuario->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <script>
                                        function preguntar{{$usuario->id}}(event){
                                            event.preventDefault();
                                            Swal.fire({
                                                title: 'Deseas eliminar este registro',
                                                text: '',
                                                icon: 'question',
                                                showDenyButton: true,
                                                confirmButtonText: 'Eliminar',
                                                confirmButtonColor: '#a5161d',
                                                denyButtonColor: '#270a0a',
                                                denyButtonText: 'Cancelar',
                                            }).then((result) => {
                                                if(result.isConfirmed){
                                                    var form = $('#miformulario{{$usuario->id}}');
                                                    form.submit();
                                                }
                                            })
                                        }
                                    </script>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
            "language":{
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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