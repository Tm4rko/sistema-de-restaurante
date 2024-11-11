@extends('adminlte::page')

@section('content_header') <h1>Stock de la Sucursal: {{ $sucursal->nombre_sucursal }}</h1>
<hr> @stop @section('content') <div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Productos</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Disponibilidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody> @foreach($productos as $producto) <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->pivot->stock }}</td>
                            <td>
                                <form action="{{ route('admin.stocks.update', $producto->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="number" name="stock" value="{{ $producto->pivot->stock }}" class="form-control">
                                    <select name="disponibilidad" class="form-control">
                                        <option value="1" {{ $producto->pivot->disponibilidad ? 'selected' : '' }}>Disponible</option>
                                        <option value="0" {{ !$producto->pivot->disponibilidad ? 'selected' : '' }}>No Disponible</option>
                                    </select> <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
                                </form>
                            </td>
                        </tr> @endforeach </tbody>
                </table>
            </div>
        </div>
    </div>
</div> @stop