<title>Productos</title>
<link rel="icon" type="image/png" href="{{ asset('imagenes/botica2.png') }}">
@extends('layouts.app')

@section('content')
    @vite('resources/css/welcome.css')
    <section class="py-5">
        <div class="container" style="max-width: 1400px;">








            <div class="row gx-5">
                <!-- BOTÓN FILTRO SOLO EN CELULAR -->
                <div class="col-12 d-md-none mb-3">
                    <button class="btn btn-success w-100" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasFiltro" aria-controls="offcanvasFiltro">
                        <i class="bi bi-funnel-fill"></i> Filtros
                    </button>
                </div>

                <!-- FILTRO LATERAL EN PANTALLAS GRANDES -->
                <div class="col-12 col-md-4 col-lg-3 mb-4 d-none d-md-block">
                    <div class="product-categories-widget widget-item card shadow-sm h-100">
                        <div class="card-body">
                            <h2 class="widget-title mb-3">🛍️ Categorías de Productos</h2>


                            <ul class="category-tree list-unstyled mb-0" style="max-height: 700px; overflow-y: auto;">
                                {{-- Todos los productos --}}
                                <li class="category-item mb-2">
                                    <div class="category-header">
                                        <a href="{{ route('productos.filtro') }}"
                                            class="category-link {{ request('categorias') ? '' : 'fw-bold text-dark' }}">
                                            Todos
                                        </a>
                                    </div>
                                </li>

                                {{-- Lista de categorías --}}
                                @foreach ($categorias as $categoria)
                                    @php
                                        $activa =
                                            is_array(request('categorias')) &&
                                            in_array($categoria->id, request('categorias'));
                                    @endphp
                                    <li class="category-item mb-2">
                                        <div class="category-header">
                                            <a href="{{ route('productos.filtro', array_merge(request()->except('page', 'categorias'), ['categorias[]' => $categoria->id])) }}"
                                                class="category-link {{ $activa ? 'fw-bold text-danger' : 'text-dark' }}">
                                                {{ $categoria->nombre }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- OFFCANVAS FILTRO SOLO EN CELULAR -->
                <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasFiltro"
                    aria-labelledby="offcanvasFiltroLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasFiltroLabel">🛍️ Categorías de Productos</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="category-tree list-unstyled mb-0" style="max-height: 700px; ">
                            {{-- Todos los productos --}}
                            <li class="category-item mb-2">
                                <div class="category-header">
                                    <a href="{{ route('productos.filtro') }}"
                                        class="category-link {{ request('categorias') ? '' : 'fw-bold text-dark' }}">
                                        Todos
                                    </a>
                                </div>
                            </li>

                            {{-- Lista de categorías --}}
                            @foreach ($categorias as $categoria)
                                @php
                                    $activa =
                                        is_array(request('categorias')) &&
                                        in_array($categoria->id, request('categorias'));
                                @endphp
                                <li class="category-item mb-2">
                                    <div class="category-header">
                                        <a href="{{ route('productos.filtro', array_merge(request()->except('page', 'categorias'), ['categorias[]' => $categoria->id])) }}"
                                            class="category-link {{ $activa ? 'fw-bold text-danger' : 'text-dark' }}">
                                            {{ $categoria->nombre }}
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>


                <!-- PRODUCTOS -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <form action="{{ route('productos.buscar') }}" method="get" class="flex-grow-1"
                            style="max-width: 500px;">
                            <div class="input-group shadow-sm">
                                <input type="text" class="form-control bg-white border-secondary text-black"
                                    name="keyword" placeholder="Buscar productos..." value="{{ request('keyword') }}">
                                <button class="btn btn-success" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>

                        <form method="GET" action="{{ route('productos.filtro') }}" id="filtro-form">
                            <select name="orden" class="form-select border-success text-dark w-auto shadow-sm"
                                style="min-width: 220px;" onchange="document.getElementById('filtro-form').submit();">
                                <option value="">Ordenar por</option>
                                <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>
                                    Precio: Menor a Mayor</option>
                                <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>
                                    Precio: Mayor a Menor</option>
                                <option value="az" {{ request('orden') == 'az' ? 'selected' : '' }}>
                                    Nombre: A-Z</option>
                                <option value="za" {{ request('orden') == 'za' ? 'selected' : '' }}>
                                    Nombre: Z-A</option>
                            </select>
                        </form>
                    </div>

                    <!-- Grid -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                        @php $carrito = session('carrito', []); @endphp
                        @forelse($productos as $producto)
                            <div class="col">
                                <div class="card h-100 shadow-sm border-0 product-card">
                                    <a href="{{ route('productos.especificaciones', $producto->id) }}" class="p-3 pb-0">
                                        @if ($producto->imagen)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}"
                                                class="card-img-top tab-image" alt="{{ $producto->nombre }}">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=Sin+Imagen"
                                                class="card-img-top tab-image" alt="Sin Imagen">
                                        @endif
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-semibold mb-1">{{ $producto->nombre }}</h5>
                                        <small
                                            class="text-muted mb-2">{{ $producto->presentacion?->tipo_presentacion ?? 'Sin presentación' }}</small>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="price fw-bold fs-5">S/.
                                                {{ number_format($producto->pvp1, 2) }}</span>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="d-flex align-items-center justify-content-between mb-2"
                                                id="carrito-container-{{ $producto->id }}">
                                                @if (isset($carrito[$producto->id]))
                                                    <a href="{{ route('carrito.ver') }}"
                                                        class="btn btn-outline-success w-100 fw-semibold">
                                                        Ver carrito
                                                        <i class="bi bi-cart-check-fill ms-2"></i>
                                                    </a>
                                                @else
                                                    <div class="d-flex w-100 align-items-center">
                                                        <div class="input-group product-qty " style="width: 50%;">
                                                            <button type="button" class="quantity-left-minus btn-number">
                                                                <svg width="13" height="13" viewBox="0 0 24 24"
                                                                    fill="none">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>

                                                            <input type="text"
                                                                class="form-control input-number text-center"
                                                                value="1" style="max-width: 50px;">

                                                            <button type="button" class="quantity-right-plus btn-number">
                                                                <svg width="16" height="16" viewBox="0 0 24 24"
                                                                    fill="none">
                                                                    <use xlink:href="#plus"></use>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <form method="POST"
                                                            action="{{ route('carrito.agregar', $producto->id) }}"
                                                            class="agregar-carrito-form ms-3 flex-grow-1">
                                                            @csrf
                                                            <input type="hidden" name="cantidad" value="1">
                                                            <button type="submit" class="w-100 fw-semibold btn-add-cart">
                                                                Agregar
                                                                <i class="bi bi-cart"></i>
                                                            </button>

                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- ⚡ TEMPLATE PARA RESTAURAR DESPUÉS DE ELIMINAR --}}
                                            <template id="form-agregar-{{ $producto->id }}">
                                                <div class="d-flex w-100 align-items-center">
                                                    <div class="input-group product-qty" style="width: 50%;">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-left-minus btn btn-number"
                                                                data-type="minus" aria-label="restar">
                                                                <svg width="13" height="13">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>

                                                        <input type="text"
                                                            class="form-control input-number text-center" value="1"
                                                            aria-label="cantidad">

                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-right-plus btn btn-number"
                                                                data-type="plus" aria-label="sumar">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#plus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    </div>

                                                    <form method="POST"
                                                        action="{{ route('carrito.agregar', $producto->id) }}"
                                                        class="agregar-carrito-form ms-3 flex-grow-1">
                                                        @csrf
                                                        <input type="hidden" name="cantidad" value="1">
                                                        <button type="submit"
                                                            class="w-100 fw-semibold btn-add-cart btn btn-primary d-flex flex-column align-items-center">
                                                            <span>Agregar</span>
                                                            <i class="bi bi-cart mt-1"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">No hay productos disponibles.</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $productos->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- ICONOS SVG (plus/minus) -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
        <symbol id="plus" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
        </symbol>
        <symbol id="minus" viewBox="0 0 24 24">
            <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
        </symbol>
    </defs>
</svg>

<style>
    .product-qty {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        /* pequeño espacio entre botones e input */
        width: 50%;
        /* mantén si quieres */
    }

    .product-qty .btn-number {
        background: transparent !important;
        border: none !important;
        color: black !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 6px;
        cursor: pointer;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 0 !important;
    }

    .product-qty .btn-number svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    .quantity-right-plus:hover {
        background-color: #228B22 !important;
        /* forest green */
        color: white !important;
    }


    .quantity-left-minus:hover {
        background-color: #b02a37 !important;
        /* rojo oscuro */
        color: white !important;
    }

    .product-qty .input-number {
        max-width: 50px;
        height: 28px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-weight: bold;
        line-height: 28px;
        /* altura de línea igual a la altura para centrar */
        padding: 0;
        /* quitar padding para evitar desalineación */
        box-sizing: border-box;
    }

    .btn-add-cart {
        border: none !important;
        background-color: transparent !important;
        color: black !important;
        box-shadow: none !important;
        padding: 0.35rem 0.5rem;
        transition: color 0.3s ease;
    }

    .btn-add-cart:hover {
        color: #dc3545 !important;
        /* rojo Bootstrap 'danger' */
        background-color: transparent !important;
        border: none !important;
        text-decoration: none;
        cursor: pointer;
    }

    a.btn-outline-success.w-100.fw-semibold {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: black !important;
        transition: color 0.3s ease;
        padding: 0.5rem 1rem;
        /* más espacio arriba-abajo y lados */
        font-size: 1.2rem;
        /* texto más grande */
        margin-top: 12px;
        /* baja el botón */
        text-align: center;
        display: inline-block;
        /* para que margin-top funcione bien */
    }

    a.btn-outline-success.w-100.fw-semibold:hover {
        color: #dc3545 !important;
        background-color: transparent !important;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<!-- JS para cantidades y AJAX (vanilla JS) -->
<!-- JS para cantidades (sin duplicar AJAX, eso lo maneja app.blade.php) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sincronizar cantidad visible con el input hidden del form dentro de cada tarjeta
        document.querySelectorAll('.product-card').forEach(function(card) {
            const visibleInput = card.querySelector('.input-number');
            const plusBtn = card.querySelector('.quantity-right-plus');
            const minusBtn = card.querySelector('.quantity-left-minus');
            const form = card.querySelector('.agregar-carrito-form');
            const hiddenInput = form ? form.querySelector('input[name="cantidad"]') : null;

            if (!visibleInput) return;

            // init: si hidden existe, setear al valor visible
            if (hiddenInput) hiddenInput.value = visibleInput.value || 1;

            plusBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                let qty = parseInt(visibleInput.value) || 1;
                qty = qty + 1;
                visibleInput.value = qty;
                if (hiddenInput) hiddenInput.value = qty;
            });

            minusBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                let qty = parseInt(visibleInput.value) || 1;
                if (qty > 1) qty = qty - 1;
                visibleInput.value = qty;
                if (hiddenInput) hiddenInput.value = qty;
            });

            visibleInput.addEventListener('input', function() {
                let qty = parseInt(this.value);
                if (isNaN(qty) || qty < 1) qty = 1;
                this.value = qty;
                if (hiddenInput) hiddenInput.value = qty;
            });
        });
    });
</script>



<style>
    .tab-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 10px;
    }

    @media (max-width: 576px) {
        .tab-image {
            height: 160px;
        }
    }

    .product-card {
        transition: transform 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-3px);
    }

    .product-qty .btn {
        padding: 0.35rem 0.5rem;
    }
</style>
