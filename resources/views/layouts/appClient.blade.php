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

            <li class="nav-item">
              @if(isset($sucursalSeleccionada))
              <span class="nav-link badge bg-primary">Sucursal: {{ $sucursalSeleccionada->nombre_sucursal }}</span>
              @endif
            </li>
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