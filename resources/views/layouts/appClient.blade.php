<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <style>
    .bg-danger {
      background: #302825 !important
    }
  </style>
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a href="" class="navbar-brand" href="">
          <img src="{{ asset('/images/logo.png')}}" alt="" width="50px">
        </a>
        <div>
          @if(isset($sucursalSeleccionada))
          <span class="nav-link badge bg-primary">Sucursal: {{ $sucursalSeleccionada->nombre_sucursal }}</span>
          @endif
        </div>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav ms-auto">

          </ul>
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{route('index')}}">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('listaProductos')}}">Realiza tu PEDIDO</a>
            </li>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            @if (Cart::content()->count())
            <li class="nav-item">
              <a class="nav-link position-relative" href="vercarrito">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                </svg>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  {{Cart::content()->count()}}
                  <span class="visually-hidden">unread messages</span>
                </span>
              </a>
            </li>
            @endif
            <!-- Authentication Links -->
            @guest
            @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
            </li>
            @endif
            @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Regístrate') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
            @endguest
          </ul>
        </div>

      </div>
    </nav>
    @yield('content')

  </div>
  <div class="container mt-5">
    <p class="text-center">&copy; Todos los derechos reservados | El Buen Sabor | 2024</p>
  </div>


  <!-- Modal para Selección de Sucursal -->
  <div class="modal fade" id="sucursalModal" tabindex="-1" aria-labelledby="sucursalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('cliente.sucursal.select') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="sucursalModalLabel">Seleccione la Sucursal</h5>
          </div>
          <div class="modal-body"> @foreach($sucursales as $sucursal)
            <div class="form-check">
              <input class="form-check-input" type="radio" name="sucursal_id" id="sucursal{{ $sucursal->id }}" value="{{ $sucursal->id }}" required>
              <label class="form-check-label" for="sucursal{{ $sucursal->id }}"> {{ $sucursal->nombre_sucursal }} </label>
            </div>
            @endforeach
          </div>
          <div class="modal-footer"> <button type="submit" class="btn btn-primary">Seleccionar</button> </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<!-- Scripts -->
<script>
  $(document).ready(function() {
    @if(session('showSucursalModal'))
    $('#sucursalModal').modal('show');
    $('#sucursalModal').attr('aria-hidden', 'false'); // Cambiar aria-hidden a false
    @endif
  });
</script>