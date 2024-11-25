@extends('adminlte::page')

@section('content_header') <h1>Stock de la Sucursal: {{ $sucursal->nombre_sucursal }}</h1>
<hr> @stop @section('content') <div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Productos</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr style="text-align: center;">
                            <th style="text-align: left;">Producto</th>
                            <th>Stock</th>
                            <th>Actualiza el stock</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody> @foreach($productos as $producto) <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td style="text-align: center;">{{ $producto->pivot->stock }}</td>
                            <form action="{{ route('admin.stocks.update', $producto->id) }}" method="POST">
                                @csrf @method('PUT')
                                <td>
                                    <div class="row">
                                        <div class="col"><input type="number" name="stock" value="{{ $producto->pivot->stock }}" style="text-align: end;" class="form-control" onkeydown="evitarPunto(event)"></div>
                                        <!--<div class="col">
                                            <select name="disponibilidad" class="form-control">
                                                <option value="1" {{ $producto->pivot->disponibilidad ? 'selected' : '' }}>Disponible</option>
                                                <option value="0" {{ !$producto->pivot->disponibilidad ? 'selected' : '' }}>No Disponible</option>
                                            </select>
                                        </div>-->
                                    </div>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary mt-2 w-100">Actualizar</button>
                                </td>
                            </form>
                        </tr> @endforeach </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div> @stop

@section('js')
<script>
    // Mostrar mensaje de éxito o error usando SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('mensaje'))
            Swal.fire({
                text: '{{ session('mensaje') }}',
                icon: '{{ session('icono') }}',
                confirmButtonText: 'Aceptar',
                position: 'center',
                timer: 3000,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
    });
</script>

@stop