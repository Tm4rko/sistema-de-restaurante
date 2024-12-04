@extends('layouts.appClient')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 bg-light">
            <h1 class="text-center fs-4 p-3">Carrito</h1>
            <!-- Mostrar mensajes de la sesión -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" id="success-message" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button>
            </div> @endif @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" id="error-message" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (Cart::content()->count())
            <table class="table table-striped">
                <thead class="text-center">
                    <th>Foto</th>
                    <th>Producto</th>
                    <th>Detalles</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>SubTotal</th>
                    <th></th>
                </thead>
                <tbody class="text-center">
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td><img src="{{asset('storage/'.$item->options->imagen)}}" width="100"></td>
                        <td id="idTitleItem{{$item->id}}">{{$item->name}}</td>
                        <td class="text-wrap" style="max-width: 200px;">{{$item->options->especificacion}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{number_format($item->qty * $item->price,2)}}</td>
                        <td><a href="eliminaritem/{{$item->rowId}}" class="btn btn-sm text-danger" id="eliminarItem{{$item->id}}">x</a></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7">
                            <p class="text-end m-0 p-0">Total Bs. {{Cart::total()}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center mt-5 mb-5 text-center">
                <div class="col-sm-4">
                    <a href="eliminarcarrito" class="btn btn-outline-danger">Eliminar Carrito</a>
                </div>
                <div class="col-sm-4">
                    @auth
                    <a href="confirmarcarrito" class="btn btn-success">Ordenar ahora</a>
                    @else
                    <a href="/login" class="btn btn-danger">Entra para ordenar</a>
                    @endauth
                </div>
            </div>
            @else
            <p class="text-center">Carrito vacio</p>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.classList.remove('show');
                successMessage.classList.add('fade');
            }
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.classList.remove('show');
                errorMessage.classList.add('fade');
            }
        }, 3000); // Ocultar después de 3 segundos 
    });
</script>
@endsection