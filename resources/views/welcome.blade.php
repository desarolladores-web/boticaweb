@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="es">

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
  <section class="py-5 container">
    <div class="container-fluid">
      <div class="row justify-content-center"> <!-- Aquí añadimos 'justify-content-center' para centrar las tarjetas -->
        <div class="col-md-12">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              <!-- Product Grid -->
              <div
                class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
                @forelse($productos as $producto)
                <div class="col mb-4"> <!-- Añadí 'mb-4' para agregar un margen en la parte inferior de cada tarjeta -->
                  <div class="product-item product-card">
                    <figure>
                      <a href="{{ route('productos.especificaciones', $producto->id) }}"
                        title="{{ $producto->nombre }}">
                        @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="tab-image"
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

                      <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}" class="agregar-carrito-form">
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.product-card').each(function() {
        var $card = $(this);
        var $qtyInput = $card.find('.input-number');
        var $btnPlus = $card.find('.quantity-right-plus');
        var $btnMinus = $card.find('.quantity-left-minus');
        var $hiddenInput = $card.find('input[name="cantidad"]');

        $btnPlus.on('click', function(e) {
          e.preventDefault();
          let currentQty = parseInt($qtyInput.val()) || 0;
          currentQty++;
          $qtyInput.val(currentQty);
          $hiddenInput.val(currentQty);
        });

        $btnMinus.on('click', function(e) {
          e.preventDefault();
          let currentQty = parseInt($qtyInput.val()) || 0;
          if (currentQty > 1) currentQty--;
          $qtyInput.val(currentQty);
          $hiddenInput.val(currentQty);
        });

        // Si se escribe a mano en el input, también sincroniza
        $qtyInput.on('input', function() {
          let currentQty = parseInt($(this).val()) || 1;
          if (currentQty < 1) currentQty = 1;
          $(this).val(currentQty);
          $hiddenInput.val(currentQty);
        });
      });
    });
  </script>


  <script src="https://code.iconify.design/2/2.0.0/iconify.min.js"></script>

</body>

<style>
  .tab-image {
    width: 100% !important;
    height: 250px !important;
    object-fit: cover !important;
    border-radius: 10px;
  }
</style>

</html>

@endsection