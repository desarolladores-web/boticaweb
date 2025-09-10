<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('imagenes/botica2.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')




</head>

<body class="d-flex flex-column min-vh-100">

    <div id="app">
        <!-- Header Section -->
        <header id="appHeader">
            <div class="header-top py-4">
                <div class="container-fluid">
                    <div class="row align-items-center text-white gy-2">
                        <!-- Horario de atención -->
                        <div class="col-12 col-md-auto text-center text-md-start">
                            <i class="bi bi-clock me-1"></i> Lunes a Domingo: 7:00am - 9:30pm
                        </div>

                        <!-- Información de contacto -->
                        <div class="col-12 col-md d-flex flex-wrap justify-content-center justify-content-md-end gap-3">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=boticamyryan@gmail.com"
                                target="_blank" class="text-white d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-1"></i> boticamyryan@gmail.com
                            </a>
                            <span class="d-flex align-items-center">
                                <i class="bi bi-telephone-outbound-fill me-1"></i> +51 954187305
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <nav class="navbar navbar-expand-md navbar-light bg-light ">
                <div class="container">
                    <!-- Logo -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('imagenes/botica2.png') }}" class="img-fluid" alt="Logo"
                            style="height: 60px;">
                    </a>

                    <input type="checkbox" id="menu-toggle" class="d-none">
                    <label for="menu-toggle" class="navbar-toggler">
                        <span class="navbar-toggler-icon"></span>
                    </label>

                    <!-- Menú colapsable -->
                    <div class="collapse navbar-collapse align-items-center" id="navbarResponsive">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0 gap-4">
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-dark {{ request()->is('/') ? 'active' : '' }}"
                                    href="{{ url('/') }}">
                                    Inicio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-dark {{ request()->is('producto-filtro') ? 'active' : '' }}"
                                    href="{{ url('/producto-filtro') }}">
                                    Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-dark {{ request()->is('consejos') ? 'active' : '' }}"
                                    href="{{ url('/consejos') }}">
                                    Consejos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-dark {{ request()->is('quienes-somos') ? 'active' : '' }}"
                                    href="{{ url('/quienes-somos') }}">
                                    Quienes somos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-dark {{ request()->is('contactanos') ? 'active' : '' }}"
                                    href="{{ url('/contactanos') }}">
                                    Contáctanos
                                </a>
                            </li>

                        </ul>
                    </div>



                    <!-- Barra de búsqueda y otros íconos -->
                    <div class="d-flex align-items-center">
                        <form action="{{ route('productos.buscar') }}" method="get" class="search-group me-3"
                            style="min-width: 200px;">
                            <input type="text" class="form-control" name="keyword" placeholder="Buscar"
                                value="{{ request('keyword') }}">
                            <button type="submit" class="btn border-0 shadow-none p-0">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>


                        <!-- Icono de cuenta -->
                        <div class="dropdown ms-2 ">
                            <a class="btn dropdown-toggle px-0 d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" style="color: inherit;">
                                @auth
                                    @if (Auth::user()->imagen)
                                        <img src="data:image/jpeg;base64,{{ base64_encode(Auth::user()->imagen) }}" alt="Avatar"
                                            class="rounded-circle shadow-sm"
                                            style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                    @endif
                                    <span class="ms-2 fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
                                @else
                                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                @endauth
                            </a>

                            <div class="dropdown-menu dropdown-menu-end p-2 shadow rounded-3 "
                                style="min-width: 200px; left: 50%; transform: translateX(-50%);">
                                @guest
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('register') }}">
                                        <i class="bi bi-pencil-square me-2"></i> Registrarse
                                    </a>
                                @else
                                    @if (Auth::user()->rol_id == 1)
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Panel Admin
                                        </a>
                                    @else
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('account.edit') }}">
                                            <i class="bi bi-person-lines-fill me-2"></i> Mi Cuenta
                                        </a>
                                    @endif
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-bag-check me-2"></i> Pedidos
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item d-flex align-items-center text-danger"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endguest
                            </div>
                        </div>



                        <!-- Carrito -->
                        @php
                            $carrito = session('carrito', []);
                            $cantidadTotal = count($carrito);
                        @endphp

                        <div class="item ms-4">
                            <a href="#" class="header-cart-icon position-relative">
                                <i class="bi bi-cart-fill" style="font-size: 1.5rem; color:black; margi"></i>
                                <span id="contador-carrito"
                                    class="icon-quantity position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cantidadTotal }}
                                </span>


                            </a>
                        </div>

                    </div>
                </div>
    </div>
    </nav>


    <style>
        #appHeader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        body {
            padding-top: 115px;
        }

        .navbar-nav .nav-link {
            position: relative;
            padding-bottom: 5px;
            /* espacio para la línea */
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            /* grosor de la línea */
            background-color: red;
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
            /* la línea aparece */
        }

        /* Estilos buscador */
        .search-group {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .search-group input {
            height: 38px;
        }

        .search-group button {
            height: 38px;
        }

        .btn.border-0.shadow-none.p-0 {
            margin-right: 11px;
        }


        @media (max-width: 768px) {
            .search-group input {
                width: 100%;
                margin-bottom: 10px;
            }

            .navbar .dropdown-toggle span {
                display: none;
            }

            .navbar .form-control {
                font-size: 0.9rem;
            }

            .navbar .btn {
                font-size: 0.9rem;
            }

            #navbarResponsive {
                display: none;
                flex-direction: column;
                background: #f8f9fa;
                padding: 1rem;
            }

            #menu-toggle:checked~#navbarResponsive {
                display: flex;
            }
        }
    </style>
    </header>
    </div>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    </li>

    </ul>
    </div>
    </div>
    </nav>

    <main class="flex-fill py-4" style="background-color: #f5f7fa;">
        @yield('content')
    </main>

   
    <footer class="mt-auto">
        @include('layouts.footer')
    </footer>

    </div>

    <!-- SIDEBAR DEL CARRITO -->
    <div id="cartSidebar" class="cart-sidebar bg-white shadow-lg {{ session('abrir_sidebar') ? 'show' : '' }}">
        <div class="cart-header d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0">Mi carrito</h5>
            <button id="closeCartBtn"
                class="btn btn-sm btn-outline-secondary d-grid aling-items-center">&times;</button>
        </div>

        <div class="cart-body p-3" id="cart-items">
            @php $carrito = session('carrito', []); @endphp

            @if (count($carrito) > 0)
                <div class="cart-body p-3" id="cart-items">
                    @include('components.cart-items')
                </div>
            @else
                <p class="text-muted">Tu carrito está vacío.</p>
            @endif
        </div>

        <div class="cart-footer p-3 border-top">
            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                @php
                    $total = 0;
                    foreach ($carrito as $item) {
                        $total += $item['precio'] * $item['cantidad'];
                    }
                @endphp
                <span class="text-success" id="cart-total">S/. {{ number_format($total, 2) }}</span>
            </div>

            <!-- BOTÓN DIFERENTE SEGÚN LOGIN -->
            @auth
                <a href="{{ route('checkout.formulario') }}" class="btn btn-danger rounded-pill mt-3 w-100">
                    Comprar ahora
                </a>
            @endauth

            @guest
                <button type="button" class="btn btn-danger rounded-pill mt-3 w-100" data-bs-toggle="modal"
                    data-bs-target="#checkoutModal">
                    Comprar ahora
                </button>
            @endguest
        </div>

        <a href="{{ route('carrito.ver') }}"
            class="button w-100 d-flex align-items-center justify-content-center text-decoration-none"
            style="font-size: 12px; font-weight: 100; padding: 25px;">
            Ver carrito
            <span class="iconify ms-2" data-icon="bi:cart-check-fill" style="font-size: 20px;"></span>
        </a>
    </div>
     @include('layouts.whatsapp')   

    <!-- MODAL SOLO PARA INVITADOS -->
    @guest
        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="checkoutModalLabel">¿Cómo deseas continuar?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Para finalizar tu compra, puedes iniciar sesión o continuar sin cuenta.</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-circle me-2"></i> Iniciar sesión / Registrarse
                            </a>
                            <a href="{{ route('checkout.formulario') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-right me-2"></i> Continuar sin cuenta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest


    <!-- BACKDROP -->
    <div id="cartBackdrop" class="cart-backdrop {{ session('abrir_sidebar') ? 'show' : '' }}"></div>


    <style>
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 350px;
            height: 100vh;
            z-index: 1050;
            transition: all 0.3s ease-in-out;
            overflow-y: auto;
        }

        .cart-sidebar.show {
            right: 0;
        }

        .cart-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        .cart-backdrop.show {
            display: block;
        }

        .cart-sidebar.show~.whatsapp-float {
            display: none !important;
        }

        .cart-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
        }



        .btn-sm {
            font-size: 0.85rem;
            padding: 4px 8px;
        }
    </style>
    <style>
        .header-desktop {
            margin-top: -10px;
        }
    </style>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/2/2.0.0/iconify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.agregar-carrito-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // evita que recargue la página

                const url = this.action;
                const formData = new FormData(this);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        // ✅ Actualizar contador del carrito
                        document.getElementById('contador-carrito').textContent = data.cantidadTotal;

                        // ✅ Actualizar contenido del sidebar sin abrirlo automáticamente
                        if (typeof actualizarSidebarCarrito === 'function') {
                            actualizarSidebarCarrito();
                        }
                    })
                    .catch(error => {
                        console.error('Error al agregar al carrito:', error);
                    });
            });
        });
    </script>

    <script>
        function actualizarSidebarCarrito() {
            fetch('{{ route('carrito.sidebar.ajax') }}')
                .then(res => res.json())
                .then(data => {
                    // Actualizar los ítems del carrito
                    const sidebarItems = document.getElementById('cart-items');
                    if (sidebarItems) {
                        sidebarItems.innerHTML = data.items_html;
                    }

                    // Actualizar el total
                    const cartTotal = document.getElementById('cart-total');
                    if (cartTotal) {
                        cartTotal.textContent = 'S/. ' + data.total;
                    }
                })
                .catch(error => console.error('Error actualizando sidebar:', error));
        }
    </script>
    <!-- Esto ponlo en tu layout principal, no en el partial -->
    <script>
        document.addEventListener('submit', function (e) {
            if (e.target.matches('.form-actualizar-cantidad, .eliminar-item-form, .agregar-carrito-form')) {
                e.preventDefault();

                const form = e.target;
                const url = form.action;
                const formData = new FormData(form);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        // 🔹 Actualizar contador global
                        const contador = document.getElementById('contador-carrito');
                        if (contador && data.cantidadTotal !== undefined) {
                            contador.textContent = data.cantidadTotal;
                        }

                        // 🔹 Cambiar bloque por "Ver carrito"
                        if (data.success && form.classList.contains('agregar-carrito-form')) {
                            const tarjetaContainer = form.closest('[id^="carrito-container-"]');
                            if (tarjetaContainer) {
                                tarjetaContainer.innerHTML = `
                        <a href="{{ route('carrito.ver') }}"
                            class="button w-100 d-flex align-items-center justify-content-center text-decoration-none"
                            style="font-size: 15px; font-weight: 100; padding: 25px;">
                            Ver carrito
                            <span class="iconify ms-2" data-icon="bi:cart-check-fill" style="font-size: 25px;"></span>
                        </a>
                    `;
                            }
                        }

                        // 🔹 Restaurar template al eliminar
                        if (data.eliminado && data.producto_id) {
                            const sidebar = document.getElementById('cart-items');
                            if (sidebar) {
                                const productoSidebarElem = sidebar.querySelector(`[data-id="${data.producto_id}"]`);
                                if (productoSidebarElem) productoSidebarElem.remove();
                                if (sidebar.children.length === 0) {
                                    sidebar.innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
                                }
                            }

                            const tarjetaContainer = document.getElementById('carrito-container-' + data.producto_id);
                            const template = document.getElementById('form-agregar-' + data.producto_id);
                            if (tarjetaContainer && template) {
                                tarjetaContainer.innerHTML = template.innerHTML;
                                inicializarBotonesCantidad(tarjetaContainer); // reactivar botones e input
                            }
                        }

                        // 🔹 Carrito vacío
                        if (data.vacio) {
                            const contenedor = document.getElementById('cart-items');
                            if (contenedor) {
                                contenedor.innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
                            }
                        }

                        if (typeof actualizarSidebarCarrito === 'function') {
                            actualizarSidebarCarrito();
                        }
                    })
                    .catch(error => console.error('Error en acción del carrito:', error));
            }
        });

        /**
         * 🔹 Inicializa los controles de cantidad (+, -, input manual)
         */
        function inicializarBotonesCantidad(scope = document) {
            scope.querySelectorAll('.product-qty').forEach(group => {
                const input = group.querySelector('.input-number');
                const form = group.parentElement.querySelector('form');
                const hiddenInput = form ? form.querySelector('input[name="cantidad"]') : null;

                // Botones ➕ y ➖
                group.querySelectorAll('button[data-type="minus"], button[data-type="plus"]').forEach(btn => {
                    btn.addEventListener('click', function () {
                        let value = parseInt(input.value) || 1;
                        if (this.dataset.type === 'minus' && value > 1) value--;
                        if (this.dataset.type === 'plus') value++;
                        input.value = value;
                        if (hiddenInput) hiddenInput.value = value;
                    });
                });

                // Escritura manual en el input
                input.addEventListener('input', function () {
                    let value = parseInt(input.value) || 1;
                    if (value < 1) value = 1;
                    input.value = value;
                    if (hiddenInput) hiddenInput.value = value;
                });
            });
        }

        // Inicializar en carga
        document.addEventListener('DOMContentLoaded', () => inicializarBotonesCantidad());
    </script>



    <script>
        function actualizarSidebarCarrito() {
            fetch('{{ route('carrito.sidebar.ajax') }}')
                .then(res => res.json())
                .then(data => {
                    // Actualizar los ítems del carrito
                    const sidebarItems = document.getElementById('cart-items');
                    if (sidebarItems) {
                        sidebarItems.innerHTML = data.items_html;
                    }

                    // Actualizar el total
                    const cartTotal = document.getElementById('cart-total');
                    if (cartTotal) {
                        cartTotal.textContent = 'S/. ' + data.total;
                    }
                })
                .catch(error => console.error('Error actualizando sidebar:', error));
        }
    </script>







</body>

</html>