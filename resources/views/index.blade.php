@extends('layouts.appClient')

<style>
  .carousel-item {
    display: flex;
    justify-content: center;
  }

  .carousel-item img {
    width: 24%;
    /* Ajusta el ancho para mostrar 4 imágenes en el contenedor */
  }

  #footer {
    background-color: #333;
    /* Color de fondo */
    color: #fff;
    /* Color de letra */
    padding: 20px 0;
  }

  #footer h3 {
    color: #ffcc00;
    /* Color de letra de los títulos */
  }

  #footer .contact-item p {
    color: #ccc;
    /* Color de letra de los párrafos */
  }
</style>


@section('content')
<div class="container-fluid bg-danger">
  <img src="{{asset('assets/img/head1.jpg')}}" alt="" class="img-fluid mx-auto d-block">
</div>
<!-- About Section -->
<div id="about" style="margin-top: 20px">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="about-img">
          <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid" alt="Imagen de El Buen Sabor">
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="about-text">
          <h2>Nuestro Restaurante</h2>
          <hr>
          <p>"El Buen Sabor" una churrasquería emblemática en Ciudad de La Paz, que gracias a nuestro compromiso inquebrantable, nos consolidamos con la apertura de nuevas sucursales ubicadas en las ciudades de La Paz y El Alto.</p>
          <h3>A tu servicio</h3>
          <p>Cada visita a "El Buen Sabor" es una celebración de la tradición y la innovación culinaria, donde la calidad y el servicio son nuestra prioridad.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
<!-- Restaurant Menu Section -->
<div id="restaurant-menu">
  <div class="section-title text-center center">
    <div class="overlay">
      <h2>Menú</h2>
      <hr>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit duis sed.</p>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="menu-section">
          <h2 class="menu-section-title">Cortes del Día</h2>
          <hr>
          <div class="menu-item">
            <div class="menu-item-name"> Delicious Dish </div>
            <div class="menu-item-price"> $45 </div>
            <div class="menu-item-description"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, duis sed dapibus leo nec ornare diam. </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Delicious Dish </div>
            <div class="menu-item-price"> $30 </div>
            <div class="menu-item-description"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, duis sed dapibus leo nec ornare diam. </div>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-sm-6">
        <div class="menu-section">
          <h2 class="menu-section-title">Bebidas</h2>
          <hr>
          <div class="menu-item">
            <div class="menu-item-name"> Delicious Dish </div>
            <div class="menu-item-price"> $35 </div>
            <div class="menu-item-description"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, duis sed dapibus leo nec ornare diam. </div>
          </div>
          <div class="menu-item">
            <div class="menu-item-name"> Delicious Dish </div>
            <div class="menu-item-price"> $30 </div>
            <div class="menu-item-description"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, duis sed dapibus leo nec ornare diam. </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
<!-- Portfolio Section -->
<div id="portfolio">
  <div class="container">
    <div class="section-title text-center center">
      <div class="overlay">
        <h2>Galeria</h2>
        <hr>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit duis sed.</p>
      </div>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <ol class="carousel-indicators">
        @foreach($productos->chunk(4) as $index => $chunk)
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}">

        </li> @endforeach
      </ol>
      <div class="carousel-inner">
        @foreach($productos->chunk(4) as $index => $chunk)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
          @foreach($chunk as $producto)
          <img src="{{asset('storage/'.$producto->imagen)}}" class="img-fluid" alt="Producto {{ $loop->iteration }}">
          @endforeach
        </div>
        @endforeach
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span> </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </a>
    </div>
  </div>
  <br>
  <br>
  <br>
  <!-- Call Reservation Section -->
  <div id="call-reservation" class="container-fluid text-center">
    <div class="container">
      <h3 style="font-size: 200%; line-height: 1.5">¿Deseas disfrutar de una experiencia privada y exclusiva en nuestro restaurante? Contáctanos al <strong>78589521</strong></h3>
    </div>
  </div>

  <div id="footer">
    <div class="container text-center">
      <div class="row">
        <div class="col-md-4">
          <h3>Dirección Central</h3>
          <div class="contact-item">
            <p>San Pedro</p>
            <p>Av. Héroes del Acre</p>
          </div>
        </div>
        <div class="col-md-4">
          <h3>Horas de Apertura</h3>
          <div class="contact-item">
            <p>Lun-Vie: 11:00 AM - 10:00 PM</p>
            <p>Sab-Dom: 11:00 AM - 19:00 PM</p>
          </div>
        </div>
        <div class="col-md-4">
          <h3>Información de Contacto</h3>
          <div class="contact-item">
            <p>Teléfono: 74515784</p>
            <p>Email: elbuensabor@gmail.com</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @stop