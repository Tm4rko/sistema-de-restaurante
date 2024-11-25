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
        <div class="col-sm-8">
            <div class="col-sm-12">
                <br><br>
                <h1 class="text-center">Realiza tu Pedido en Línea</h1>
                <div class="row">
                    @foreach ($categorias as $categoria)
                    <div class="col-sm-12">
                        <h2 class="text-center mt-5">{{$categoria->nombre}}</h2>
                        <div class="row justify-content-center">
                            @forelse ($categoria->productos as $producto)
                            @php $stock = $stocks[$producto->id] ?? null; $disponibilidad = $stock !== null ? \DB::table('stock_sucursales') ->where('sucursal_id', $sucursalSeleccionada->id) ->where('producto_id', $producto->id) ->value('disponibilidad') : null; @endphp @if($stock === 0 || $disponibilidad === 0) <div class="col-sm-6 mt-3 mb-3">
                                <div class="clickable-element" style="background-color: #f8d7da; padding: 10px; border: 1px solid #f5c6cb;">
                                    <div class="row">
                                        <div class="col-md-4"> <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre }}"> </div>
                                        <div class="col-md-8">
                                            <h4 class="text-center">{{ $producto->nombre }}</h4>
                                            <p class="text-center" style="color: #721c24;">Producto no disponible</p>
                                        </div>
                                    </div>
                                </div>
                            </div> @else <div class="col-sm-6 mt-3 mb-3">
                                <div class="clickable-element" data-bs-toggle="modal" data-bs-target="#productoModal-{{ $producto->id }}">
                                    <div class="row">
                                        <div class="col-md-4"> <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre }}"> </div>
                                        <div class="col-md-8">
                                            <h4 class="text-center">{{ $producto->nombre }}</h4>
                                            <p class="text-center">Bs. {{ $producto->precio_venta }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> @endif
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
                                                        <button class="btn btn-secondary btn-counter" onclick="increaseCount({{ $producto->id }}, {{ $producto->precio_venta }}, {{ $stocks[$producto->id] ?? 0 }})">+</button>
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
                                            @auth
                                            <!--<form action="{{route('agregaritem')}}" method="post" onsubmit="setFormValues({{ $producto->id }})">
                                                @csrf
                                                <input type="hidden" name="producto_id" value="{{$producto->id}}">
                                                <input type="hidden" id="qty-{{ $producto->id }}" name="qty" value="1">
                                                <input type="hidden" id="specification-{{ $producto->id }}" name="especificacion" value="">
                                                <input type="submit" value="Añadir al Carrito" class="btn btn-primary">
                                            </form>-->
                                            <form action="{{route('agregaritem')}}" method="post" onsubmit="return setFormValues({{ $producto->id }})">
                                                @csrf
                                                <input type="hidden" name="producto_id" value="{{$producto->id}}">
                                                <input type="hidden" id="qty-{{ $producto->id }}" name="qty" value="1">
                                                <input type="hidden" id="specification-{{ $producto->id }}" name="especificacion" value="">
                                                <input type="submit" value="Añadir al Carrito" class="btn btn-primary">
                                            </form>
                                            @else
                                            <button type="button" class="btn btn-primary" onclick="alert('Inicia sesión o regístrate para llenar tu carrito.')">Añadir al Carrito</button>
                                            @endauth
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

            <div class="col-sm-12">
                <br><br>
                <div class="row"> @foreach ($categoriasNoCarnes as $categoria) <div class="col-sm-12">
                        <h2 class="text-center mt-5">{{$categoria->nombre}}</h2>
                        <div class="row justify-content-center">
                            @forelse ($categoria->productos as $producto)
                            @php
                            $stock = $stocks[$producto->id] ?? null;
                            $disponibilidad = $stock !== null ? \DB::table('stock_sucursales')
                            ->where('sucursal_id', $sucursalSeleccionada->id)
                            ->where('producto_id', $producto->id)
                            ->value('disponibilidad') : null;
                            @endphp

                            @if($stock === 0 || $disponibilidad === 0)
                            <div class="col-sm-6 mt-3 mb-3">
                                <div class="clickable-element" style="background-color: #f8d7da; padding: 10px; border: 1px solid #f5c6cb;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre }}">
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="text-center">{{ $producto->nombre }}</h4>
                                            <p class="text-center" style="color: #721c24;">Producto no disponible</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-sm-6 mt-3 mb-3">
                                <div class="clickable-element" data-bs-toggle="modal" data-bs-target="#productoModal-{{ $producto->id }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre }}">
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="text-center">{{ $producto->nombre }}</h4>
                                            <p class="text-center">Bs. {{ $producto->precio_venta }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


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
                                                    <p>Precio: Bs. {{ $producto->precio_venta }} / Unidad</p>
                                                    <p>Descripción: {{ $producto->descripcion }}</p>
                                                    <h5 style="font-weight: bold;">Elige la cantidad</h5>
                                                    <div class="counter">
                                                        <button class="btn btn-secondary btn-counter" onclick="decreaseCount({{ $producto->id }}, {{ $producto->precio_venta }})">-</button>
                                                        <span id="count-{{ $producto->id }}">1</span>
                                                        <button class="btn btn-secondary btn-counter" onclick="increaseCount({{ $producto->id }}, {{ $producto->precio_venta }}, {{ $stocks[$producto->id] ?? 0 }})">+</button>
                                                    </div>
                                                    <br>
                                                    <div id="total-price-{{ $producto->id }}" class="text-end fs-4">Total: Bs {{ $producto->precio_venta }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <!--<button type="button" class="btn btn-primary">Añadir al Carrito</button>-->
                                            <form action="{{route('agregaritem')}}" method="post" onsubmit="setQtyValue({{ $producto->id }})">
                                                @csrf
                                                <input type="hidden" name="producto_id" value="{{$producto->id}}">
                                                <input type="hidden" id="qty-{{ $producto->id }}" name="qty" value="1">
                                                <input type="submit" value="Añadir al Carrito" class="btn btn-primary">
                                            </form>
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

        @if (count(Cart::content()))
        <div class="col-sm-4">
            <p class="text-center">Resumen del Carrito</p>
            <table class="table table-striped">
                <tbody>
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->options->especificacion}}</td>
                        <td>{{$item->qty}} x {{$item->price}}</td>
                        <td>{{number_format($item->qty * $item->price,2)}}</td>
                        <td><a href="eliminaritem/{{$item->rowId}}" class="btn btn-sm text-danger">x</a></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">
                            <p class="text-end m-0 p-0">Total Bs. {{Cart::total()}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="text-center"><a href="vercarrito" class="btn btn-outline-success btn-sm">Ver Carrito</a></p>
        </div>
        @endif


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

    function increaseCount(id, price, stock) {
        let count = document.getElementById(`count-${id}`);
        let currentCount = parseInt(count.textContent);
        if (currentCount < stock) {
            count.textContent = currentCount + 1;
            updateTotalPrice(id, price);
            updateMaxCount(id, price);
        } else {
            alert('No hay suficiente stock disponible.');
        }
    }

    function decreaseCount(id, price) {
        let count = document.getElementById(`count-${id}`);
        let currentCount = parseInt(count.textContent);
        if (currentCount > 1) {
            count.textContent = currentCount - 1;
            updateTotalPrice(id, price);
            updateMaxCount(id, price);
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

    //Mandar cantidad de bebidas, guarniciones y otros al controlador
    function setQtyValue(productId) {
        let qty = document.getElementById(`count-${productId}`).textContent;
        document.getElementById(`qty-${productId}`).value = qty;
    }

    //Mandar cantidad de platillos al controlador

    /*function setFormValues(productId) {
        let qty = document.getElementById(`count-${productId}`).textContent;
        let medio = document.getElementById(`count-medio-${productId}`).textContent;
        let trescuartos = document.getElementById(`count-trescuartos-${productId}`).textContent;
        let biencocido = document.getElementById(`count-biencocido-${productId}`).textContent;
        let guarniciones = @json($guarniciones);
        let guarnicionesText = '';
        guarniciones.forEach(guarnicion => {
            let count = document.getElementById(`count-guarnicion-${productId}-${guarnicion.id}`).textContent;
            guarnicionesText += `${guarnicion.nombre}: ${count}, `;
        });
        let specification = `Término de carne: Medio: ${medio}, Tres Cuartos: ${trescuartos}, Bien Cocido: ${biencocido}, Guarniciones: ${guarnicionesText}`;
        document.getElementById(`qty-${productId}`).value = qty;
        document.getElementById(`specification-${productId}`).value = specification;
    }*/
   //Mandar cantidad de platillos al controlador
function setFormValues(productId) {
    let qty = parseInt(document.getElementById(`count-${productId}`).textContent);
    let medio = parseInt(document.getElementById(`count-medio-${productId}`).textContent);
    let trescuartos = parseInt(document.getElementById(`count-trescuartos-${productId}`).textContent);
    let biencocido = parseInt(document.getElementById(`count-biencocido-${productId}`).textContent);

    let guarniciones = @json($guarniciones);
    let totalGuarniciones = 0;
    let guarnicionesText = '';

    guarniciones.forEach(guarnicion => {
        let count = parseInt(document.getElementById(`count-guarnicion-${productId}-${guarnicion.id}`).textContent);
        guarnicionesText += `${guarnicion.nombre}: ${count}, `;
        totalGuarniciones += count;
    });

    let totalTerms = medio + trescuartos + biencocido;

    if (totalGuarniciones !== qty || totalTerms !== qty) {
        alert(`Debes seleccionar exactamente ${qty} guarniciones y ${qty} términos de la carne.`);
        return false; // Evita que el formulario se envíe
    }

    let specification = `Término de carne: Medio: ${medio}, Tres Cuartos: ${trescuartos}, Bien Cocido: ${biencocido}, Guarniciones: ${guarnicionesText}`;
    
    document.getElementById(`qty-${productId}`).value = qty;
    document.getElementById(`specification-${productId}`).value = specification;
    return true;
}

</script>

@stop