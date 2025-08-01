@vite('resources/css/welcome.css')

@extends('layouts.app')

@section('content')
    <section class="py-5 container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase" style="color: #198754; font-size: 2.2rem;">
                Catálogo de Productos
            </h2>
        </div>

        <div class="row">
            <!-- FILTRO LATERAL -->
            <div class="col-md-3 mb-4">
                <div class="filtro-categorias">
                    <h5>Categorías</h5>
                    <div style="max-height: 700px; overflow-y: auto;">
                        {{-- Opción "Todos los productos" --}}
                        <a href="{{ route('productos.filtro') }}"
                            class="categoria-link {{ request('categorias') ? '' : 'active' }}">
                            Todos
                        </a>

                        @foreach($categorias as $categoria)
                            @php
                                $activa = is_array(request('categorias')) && in_array($categoria->id, request('categorias'));
                            @endphp
                            <a href="{{ route('productos.filtro', array_merge(request()->except('page', 'categorias'), ['categorias[]' => $categoria->id])) }}"
                                class="categoria-link {{ $activa ? 'active' : '' }}">
                                {{ $categoria->nombre }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>



            <!-- PRODUCTOS -->
            <div class="col-md-9">
                <form method="GET" action="{{ route('productos.filtro') }}" id="filtro-form">
                    <div class="mb-3 d-flex justify-content-end">
                        <select name="orden" class="form-select w-auto"
                            onchange="document.getElementById('filtro-form').submit();">
                            <option value="">Ordenar por</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: Menor
                                a Mayor</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio:
                                Mayor a Menor</option>
                            <option value="az" {{ request('orden') == 'az' ? 'selected' : '' }}>Nombre: A-Z</option>
                            <option value="za" {{ request('orden') == 'za' ? 'selected' : '' }}>Nombre: Z-A</option>
                        </select>
                    </div>
                </form>

                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @php $carrito = session('carrito', []); @endphp
                    @forelse($productos as $producto)
                        <div class="col">
                            <div class="product-item product-card">
                                <figure>
                                    <a href="{{ route('productos.especificaciones', $producto->id) }}"
                                        title="{{ $producto->nombre }}">
                                        @if($producto->imagen)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}"
                                                class="tab-image" alt="{{ $producto->nombre }}">
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
                                    @if(isset($carrito[$producto->id]))
                                        <a href="{{ route('carrito.ver') }}"
                                            class="button w-100 d-flex align-items-center justify-content-center text-decoration-none"
                                            style="font-size: 15px; font-weight: 100; padding: 25px;">
                                            Ver carrito
                                            <span class="iconify ms-2" data-icon="bi:cart-check-fill"
                                                style="font-size: 25px;"></span>
                                        </a>
                                    @else
                                        <div class="input-group product-qty">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus btn btn-danger btn-number"
                                                    data-type="minus">
                                                    <svg width="13" height="13">
                                                        <use xlink:href="#minus"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="quantity" class="form-control input-number"
                                                value="1">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus btn btn-success btn-number"
                                                    data-type="plus">
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
                                                <span class="iconify ms-2" data-icon="uil:shopping-cart"
                                                    style="font-size: 24px;"></span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">No hay productos disponibles.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- ICONOS SVG -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
        <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
            <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
        </symbol>
    </defs>
</svg>

<!-- JS para cantidades -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.product-card').forEach(function (card) {
            const input = card.querySelector('input[name="cantidad"]');
            const plusBtn = card.querySelector('.quantity-right-plus');
            const minusBtn = card.querySelector('.quantity-left-minus');

            if (!input || !plusBtn || !minusBtn) return;

            plusBtn.addEventListener('click', function (e) {
                e.preventDefault();
                let qty = parseInt(input.value) || 1;
                input.value = qty + 1;
            });

            minusBtn.addEventListener('click', function (e) {
                e.preventDefault();
                let qty = parseInt(input.value) || 1;
                if (qty > 1) input.value = qty - 1;
            });

            input.addEventListener('input', function () {
                let qty = parseInt(this.value);
                if (isNaN(qty) || qty < 1) this.value = 1;
            });
        });
    });
</script>

<!-- SweetAlert mensajes -->
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