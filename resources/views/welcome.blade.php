@extends('layouts.app')

@section('content')


  <head>
    <meta charset="UTF-8">
    <title>Carta de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/welcome.css'])
  </head>
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
    <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
      <path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
      <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
    </symbol>
    </defs>
  </svg>

  <body class="bg-light">
    <!-- CARRUSEL CON IMAGEN OSCURA -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000"
    style="margin-top: -30px;">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active">
      <section
        class="hero-section position-relative d-flex align-items-center justify-content-center text-center text-white"
        style="min-height: 65vh; background: url('{{ asset('imagenes/hero_bg.jpg') }}') no-repeat center center / cover;">
        <div class="overlay"></div>
        <div class="container px-3 position-relative">
        <h1 class="display-5 fw-bold text-white">Tu salud, <span class="text-success">nuestra prioridad</span></h1>
        <p class="lead text-white mb-4">Atención personalizada y medicamentos confiables <br
          class="d-none d-md-block">para ti y tu familia, cada día.</p>
        <a href="{{ url('/producto-filtro') }}" class="btn btn-light btn-lg px-4 fw-semibold">Ver productos</a>
        </div>
      </section>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
      <section
        class="hero-section position-relative d-flex align-items-center justify-content-center text-center text-white"
        style="min-height: 65vh; background: url('{{ asset('imagenes/hero_bg_2.jpg') }}') no-repeat center center / cover;">
        <div class="overlay"></div>
        <div class="container px-3 position-relative">
        <h1 class="display-5 fw-bold text-white">Todo lo que necesitas <span class="text-success">al instante</span>
        </h1>
        <p class="lead text-white mb-4">Desde analgésicos hasta vitaminas,<br class="d-none d-md-block">encuéntralo
          fácil, rápido y cerca de casa.</p>
        <a href="{{ url('/producto-filtro') }}" class="btn btn-light btn-lg px-4 fw-semibold">Comprar ahora</a>
        </div>
      </section>
      </div>

    </div>

    <!-- Botones de navegación -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>

    <!-- Features Section con Cards de farmacia con iconos -->
    <section class="py-5 bg-white">
    <div class="container">
      <div class="row g-5">

      <!-- Card 1: Entrega rápida -->
      <div class="col-12 col-md-4">
        <div class="card h-100 text-center text-dark shadow-sm border-0 rounded-4" style="background-color: #E8F5E9;">
        <div class="card-body">
          <div class="mb-3">
          <i class="bi bi-truck fs-1 text-success"></i>
          </div>
          <h5 class="card-title fw-bold text-success">Entrega rápida</h5>
          <p class="card-text">Recibe tus medicamentos directamente en tu hogar con rapidez y seguridad.</p>
          <a href="#" class="text-success fw-medium text-decoration-underline">Más información →</a>
        </div>
        </div>
      </div>

      <!-- Card 2: Medicinas nuevas -->
      <div class="col-12 col-md-4">
        <div class="card h-100 text-center text-dark shadow-sm border-0 rounded-4" style="background-color: #E3F2FD;">
        <div class="card-body">
          <div class="mb-3">
          <i class="bi bi-capsule fs-1 text-primary"></i>
          </div>
          <h5 class="card-title fw-bold text-primary">Nuevas medicinas</h5>
          <p class="card-text">Actualizamos nuestro stock con productos modernos y certificados.</p>
          <a href="#" class="text-primary fw-medium text-decoration-underline">Ver novedades →</a>
        </div>
        </div>
      </div>

      <!-- Card 3: Calidad garantizada -->
      <div class="col-12 col-md-4">
        <div class="card h-100 text-center text-dark shadow-sm border-0 rounded-4" style="background-color: #F1F8E9;">
        <div class="card-body">
          <div class="mb-3">
          <i class="bi bi-shield-check fs-1 text-success"></i>
          </div>
          <h5 class="card-title fw-bold text-success">Calidad garantizada</h5>
          <p class="card-text">Medicamentos seguros, con respaldo profesional y confianza total.</p>
          <a href="#" class="text-success fw-medium text-decoration-underline">Ver detalles →</a>
        </div>
        </div>
      </div>

      </div>
    </div>
    </section>




    <section class="py-5 container">
    <div class="container-fluid">
      <div class="row justify-content-center"> <!-- Aquí añadimos 'justify-content-center' para centrar las tarjetas -->
      <div class="col-md-12">
        <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
          <!-- Product Grid -->
          <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
          @forelse($productos as $producto)
        <div class="col mb-4"> <!-- Añadí 'mb-4' para agregar un margen en la parte inferior de cada tarjeta -->
          <div class="product-item product-card">
          <figure>
          <a href="{{ route('productos.especificaciones', $producto->id) }}"
          title="{{ $producto->nombre }}">
          @if($producto->imagen)
        <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="tab-image"
        alt="{{ $producto->nombre }}">
        @else
        <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" class="tab-image"
        alt="Sin Imagen">
        @endif
          </a>
          </figure>
          <h3>{{ $producto->nombre }}</h3>
          <span class="qty">
          {{ $producto->presentacion?->tipo_presentacion ?? 'Sin presentación' }}
          </span>

          <span class="rating">
          <svg width="24" height="24" class="text-primary"></svg>
          </span>
          <span class="price">S/. {{ number_format($producto->pvp1, 2) }}</span>




          <div class="d-flex align-items-center justify-content-between">
          @php
        $carrito = session('carrito', []);
        @endphp

          @if(isset($carrito[$producto->id]))
        {{-- Mostrar botón "Ver carrito" si el producto ya está en el carrito --}}
        <a href="{{ route('carrito.ver') }}"
        class="button w-100 d-flex align-items-center justify-content-center text-decoration-none"
        style="font-size: 15px; font-weight: 100; padding: 25px;">
        Ver carrito
        <span class="iconify ms-2" data-icon="bi:cart-check-fill" style="font-size: 25px;"></span>
        </a>


        @else
        {{-- Mostrar controles de cantidad y botón agregar --}}
        <div class="input-group product-qty">
        <span class="input-group-btn">
        <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
        <svg width="13" height="13">
          <use xlink:href="#minus"></use>
        </svg>
        </button>
        </span>
        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
        <span class="input-group-btn">
        <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
        <svg width="16" height="16">
          <use xlink:href="#plus"></use>
        </svg>
        </button>
        </span>
        </div>

        <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}"
        class="agregar-carrito-form">
        @csrf
        <input type="hidden" name="cantidad" value="1">
        <button type="submit" class="button">
        Agregar Carrito
        <span class="iconify ms-2" data-icon="uil:shopping-cart" style="font-size: 24px;"></span>
        </button>
        </form>
        @endif





          </div>
          </div>
        </div>
      @empty
        <div class="col-12">
        <div class="alert alert-warning text-center">
        No hay productos disponibles.
        </div>
        </div>
      @endforelse
          </div> <!-- End of Product Grid -->
        </div>
        </div>
      </div>
      </div>
    </div>
    </section>



    @if (session('status'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      let mensaje = '';
      let tipo = '';

      switch ("{{ session('status') }}") {
      case 'compra_exitosa':
      mensaje = '¡Compra realizada con éxito!';
      tipo = 'success';
      break;
      case 'compra_pendiente':
      mensaje = 'Tu pago está pendiente. Te notificaremos cuando se confirme.';
      tipo = 'warning';
      break;
      case 'compra_fallida':
      mensaje = 'El pago no se completó. Inténtalo nuevamente.';
      tipo = 'error';
      break;
      }

      Swal.fire({
      icon: tipo,
      title: mensaje,
      confirmButtonText: 'Aceptar',
      timer: 5000
      });
    });
    </script>
    @endif


    <script>
    $(document).ready(function () {
      $('.product-card').each(function () {
      var $card = $(this);
      var $qtyInput = $card.find('.input-number');
      var $btnPlus = $card.find('.quantity-right-plus');
      var $btnMinus = $card.find('.quantity-left-minus');
      var $hiddenInput = $card.find('input[name="cantidad"]');

      $btnPlus.on('click', function (e) {
        e.preventDefault();
        let currentQty = parseInt($qtyInput.val()) || 0;
        currentQty++;
        $qtyInput.val(currentQty);
        $hiddenInput.val(currentQty);
      });

      $btnMinus.on('click', function (e) {
        e.preventDefault();
        let currentQty = parseInt($qtyInput.val()) || 0;
        if (currentQty > 1) currentQty--;
        $qtyInput.val(currentQty);
        $hiddenInput.val(currentQty);
      });

      // Si se escribe a mano en el input, también sincroniza
      $qtyInput.on('input', function () {
        let currentQty = parseInt($(this).val()) || 1;
        if (currentQty < 1) currentQty = 1;
        $(this).val(currentQty);
        $hiddenInput.val(currentQty);
      });
      });
    });
    </script>

  </body>

  <style>
    .tab-image {
    width: 100% !important;
    height: 250px !important;
    object-fit: cover !important;
    border-radius: 10px;
    }

    .title-section {
    margin-top: 5px;
    margin-bottom: 5px;
    }
  </style>
  <!-- carrucel style-->
  <style>
    .hero-section {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    }

    .hero-section .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(73, 61, 61, 0.40);
    /* Ajusta la opacidad aquí */
    z-index: 1;
    }

    .hero-section .container {
    z-index: 2;
    }
  </style>

  </html>

@endsection