@extends('layouts.appClient')
<style>
    .clickable-element {
        cursor: pointer;
        border: 1px solid #ddd;
        /* Añade un borde a las tarjetas */
        border-radius: 5px;
        /* Bordes redondeados */
        margin-bottom: 20px;
        /* Espacio entre tarjetas */
        padding: 10px;
        /* Espacio interno */
        transition: box-shadow 0.3s;
        /* Transición para el efecto hover */
    }

    .clickable-element:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Efecto al pasar el ratón */
    }

    .modal-body img {
        width: 50%;
        height: auto;
    }

    .modal-body .info {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body .details {
        margin-left: 20px;
        flex-grow: 1;
    }

    .btn-counter {
        cursor: pointer;
        user-select: none;
    }

    .term-selection {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10"> <br><br>
            <h1 class="text-center">Realiza tu Pedido en Línea</h1>
            <div class="row"> @foreach ($categorias as $categoria) <div class="col-sm-12">
                    <h2 class="text-center mt-5">{{$categoria->nombre}}</h2>
                    <div class="row justify-content-center"> @forelse ($categoria->productos as $producto)
                        <div class="col-sm-6 mt-3 mb-3">
                            <div class="clickable-element" data-bs-toggle="modal" data-bs-target="#productoModal-{{ $producto->id }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{asset('storage/'.$producto->imagen)}}" class="img-fluid" alt="{{$producto->nombre}}">
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="text-center">{{ $producto->nombre }}</h4>
                                        <p class="text-center">Bs. {{ $producto->precio_venta }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="productoModal-{{ $producto->id }}" tabindex="-1" aria-labelledby="productoModalLabel-{{ $producto->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productoModalLabel-{{ $producto->id }}">{{ $producto->nombre }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="info">
                                            <img src="{{asset('storage/'.$producto->imagen)}}" class="img-fluid" alt="{{$producto->nombre}}">
                                            <div class="details">
                                                <p>Precio: Bs. {{ $producto->precio_venta }} / Platillos</p>
                                                <p>Descripción: {{ $producto->descripcion }}</p>
                                                <h5 style="font-weight: bold;">Elige la cantidad de platillos</h5>
                                                <div class="counter">
                                                    <button class="btn btn-secondary btn-counter" onclick="decreaseCount({{ $producto->id }}, {{ $producto->precio_venta }})">-</button>
                                                    <span id="count-{{ $producto->id }}">1</span>
                                                    <button class="btn btn-secondary btn-counter" onclick="increaseCount({{ $producto->id }}, {{ $producto->precio_venta }})">+</button>
                                                </div>
                                                <br>
                                                <div>
                                                    <h5 style="font-weight: bold;">Elige el término de la carne</h5>
                                                    <div class="counter" style="margin-bottom: 10px;">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>Medio:</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-secondary btn-counter" onclick="decreaseTerm({{ $producto->id }}, 'medio')">-</button>
                                                                <span id="count-medio-{{ $producto->id }}">0</span>
                                                                <button class="btn btn-secondary btn-counter" onclick="increaseTerm({{ $producto->id }}, 'medio')">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="counter" style="margin-bottom: 10px;">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>3/4:</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-secondary btn-counter" onclick="decreaseTerm({{ $producto->id }}, 'trescuartos')">-</button>
                                                                <span id="count-trescuartos-{{ $producto->id }}">0</span>
                                                                <button class="btn btn-secondary btn-counter" onclick="increaseTerm({{ $producto->id }}, 'trescuartos')">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="counter" style="margin-bottom: 10px;">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>Bien Cocido:</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-secondary btn-counter" onclick="decreaseTerm({{ $producto->id }}, 'biencocido')">-</button>
                                                                <span id="count-biencocido-{{ $producto->id }}">0</span>
                                                                <button class="btn btn-secondary btn-counter" onclick="increaseTerm({{ $producto->id }}, 'biencocido')">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 style="font-weight: bold;">Guarniciones</h5>
                                                    @foreach ($guarniciones as $guarnicion)
                                                    <div class="counter" style="margin-bottom: 10px;">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>{{ $guarnicion->nombre }}:</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-secondary btn-counter" onclick="decreaseGuarnicion({{ $producto->id }}, {{ $guarnicion->id }})">-</button>
                                                                <span id="count-guarnicion-{{ $producto->id }}-{{ $guarnicion->id }}">0</span>
                                                                <button class="btn btn-secondary btn-counter" onclick="increaseGuarnicion({{ $producto->id }}, {{ $guarnicion->id }})">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <div id="total-price-{{ $producto->id }}" class="text-end fs-4">Total: Bs {{ $producto->precio_venta }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Añadir al Pedido</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No hay productos disponibles en esta categoría.</p>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let guarniciones = @json($guarniciones);
</script>
<script>
    let maxCount = 1;

    function updateMaxCount(id, price) {
        let totalCount = document.getElementById(`count-${id}`).textContent;
        maxCount = parseInt(totalCount);
        resetTerms(id);
        resetGuarniciones(id);
        updateTotalPrice(id, price);
    }

    function resetTerms(id) {
        document.getElementById(`count-medio-${id}`).textContent = 0;
        document.getElementById(`count-trescuartos-${id}`).textContent = 0;
        document.getElementById(`count-biencocido-${id}`).textContent = 0;
    }

    function resetGuarniciones(id) {
        guarniciones.forEach(guarnicion => {
            document.getElementById(`count-guarnicion-${id}-${guarnicion.id}`).textContent = 0;
        });
    }

    function increaseCount(id, price) {
        let count = document.getElementById(`count-${id}`);
        let currentCount = parseInt(count.textContent);
        count.textContent = currentCount + 1;
        updateTotalPrice(id, price);
        updateMaxCount(id, price); // Asegúrate de actualizar el maxCount también
    }

    function decreaseCount(id, price) {
        let count = document.getElementById(`count-${id}`);
        let currentCount = parseInt(count.textContent);
        if (currentCount > 1) {
            count.textContent = currentCount - 1;
            updateTotalPrice(id, price);
            updateMaxCount(id, price); // Asegúrate de actualizar el maxCount también
        }
    }

    function increaseGuarnicion(productId, guarnicionId) {
        let totalCount = maxCount;
        let currentTotal = 0;

        guarniciones.forEach(guarnicion => {
            currentTotal += parseInt(document.getElementById(`count-guarnicion-${productId}-${guarnicion.id}`).textContent);
        });

        if (currentTotal < totalCount) {
            let count = document.getElementById(`count-guarnicion-${productId}-${guarnicionId}`);
            count.textContent = parseInt(count.textContent) + 1;
        }
    }

    function decreaseGuarnicion(productId, guarnicionId) {
        let count = document.getElementById(`count-guarnicion-${productId}-${guarnicionId}`);
        let currentCount = parseInt(count.textContent);
        if (currentCount > 0) {
            count.textContent = currentCount - 1;
        }
    }

    function increaseTerm(id, type) {
        let totalCount = maxCount;
        let currentTotal = 0;

        ['medio', 'trescuartos', 'biencocido'].forEach(t => {
            currentTotal += parseInt(document.getElementById(`count-${t}-${id}`).textContent);
        });

        if (currentTotal < totalCount) {
            let count = document.getElementById(`count-${type}-${id}`);
            count.textContent = parseInt(count.textContent) + 1;
        }
    }
    function decreaseTerm(id, type) {
        let count = document.getElementById(`count-${type}-${id}`);
        let currentCount = parseInt(count.textContent);
        if (currentCount > 0) {
            count.textContent = currentCount - 1;
        }
    }
    function updateTotalPrice(id, price) {
        let count = parseInt(document.getElementById(`count-${id}`).textContent);
        let totalPrice = (count * price).toFixed(2);
        document.getElementById(`total-price-${id}`).textContent = 'Total: Bs. ' + totalPrice;
    }
</script>

@stop