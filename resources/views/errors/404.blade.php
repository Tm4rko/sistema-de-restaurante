<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center my-5">
        <div class="row">
            <div class="col">
                <h1 class="display-1">404</h1>
                <h2 class="display-4">Página no encontrada</h2>
                <p class="lead">Lo sentimos, pero la página que buscas no existe. Puede haber sido movida o eliminada.</p>
                
                @if (Auth::check())
                    @if (Auth::user()->hasRole('Administrador'))
                        <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Volver al panel de administración</a>
                    @elseif (Auth::user()->hasRole('Cliente'))
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver a la página principal</a>
                    @else
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver a la página principal</a>
                    @endif
                @else
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver a la página principal</a>
                @endif
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
