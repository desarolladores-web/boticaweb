<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
</head>

<body>
    <div id="app">
        <!-- Header Section -->
        <header id="appHeader">
            <div class="header-top">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <!-- Horario de atención -->
                    <div class="header-schedule text-white">
                        <i class="bi bi-clock me-1"></i> Lunes a Sábado: 8:00am - 9:00pm
                    </div>

                    <!-- Información de contacto -->
                    <div class="top-info d-flex align-items-center gap-3">
                        <a href="mailto:boticamyryan@gmail.com" class="text-white d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-1"></i> boticamyryan@gmail.com
                        </a>
                        <span class="text-white d-flex align-items-center">
                            <i class="bi bi-telephone-outbound-fill me-1"></i> +51 xxx xxx xnxx
                        </span>
                    </div>
                </div>
            </div>

            <div class="header-desktop">
                <div class="container d-flex justify-content-between align-items-center">
                    <div class="left">
                        <h1 class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('imagenes/botica2.png') }}" class="img-fluid" alt="Logo">
                            </a>
                        </h1>

                        <div class="menu">
                            <nav class="navbar navbar-expand-md navbar-light">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Quienes somos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Consejos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/contactanos') }}">Contáctanos</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                    <div class="right">
                        <form action="{{ url('products.index') }}" method="get" class="search-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Buscar" value="{{ request('keyword') }}">
                            <button type="submit" class="btn"><i class="bi bi-search"></i></button>
                        </form>

                        <div class="icons">
                            <div class="item">
                                <div class="dropdown account-icon">
                                    <a class="btn dropdown-toggle px-0">
                                        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        @guest
                                        @if (Route::has('login'))
                                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('Inicia Sesión') }}</a>
                                        @endif

                                        @if (Route::has('register'))
                                        <a class="dropdown-item" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                        @endif
                                        @else
                                        <a class="dropdown-item" href="{{ ('profile') }}">Mi Cuenta</a>
                                        <a class="dropdown-item" href="{{ ('orders') }}">Pedidos</a>
                                        <a class="dropdown-item" href="{{ ('favorites') }}">Favoritos</a>
                                        <a class="dropdown-item" href="{{ ('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar sesión') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        @endguest
                                    </div>
                                </div>
                            </div>


                            @php
                            $carrito = session('carrito', []);
                            $cantidadTotal = count($carrito);
                            @endphp

                            <div class="item">
                                <a href="#" class="header-cart-icon position-relative">
                                    <i class="bi bi-cart-fill" style="font-size: 1.5rem; color:black;"></i>
                                    <span class="icon-quantity position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cantidadTotal }}
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <main class="py-4">
        @yield('content')
    </main>
    @include('layouts.footer')
    </div>

    <!-- SIDEBAR DEL CARRITO -->
    <div id="cartSidebar" class="cart-sidebar bg-white shadow-lg {{ session('abrir_sidebar') ? 'show' : '' }}">
        <div class="cart-header d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0">Mi carrito</h5>
            <button id="closeCartBtn" class="btn btn-sm btn-outline-secondary d-grid aling-items-center">&times;</button>
        </div>
      <div class="cart-body p-3" id="cart-items">
    @php $carrito = session('carrito', []); @endphp

    @if(count($carrito) > 0)
        @foreach($carrito as $id => $item)
        <div class="mb-3 border-bottom pb-3">
            <div class="d-flex">
                @if($item['imagen'])
                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" width="70" class="me-3 rounded">
                @endif

                <div class="flex-grow-1">
                    <div class="fw-bold">{{ $item['nombre'] }}</div>
                    <div class="text-danger fw-semibold mb-2">s/ {{ number_format($item['precio'], 2) }}</div>

                    <div class="d-flex align-items-center mb-2" style="width: fit-content;">
                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center">
                            @csrf
                            <input type="hidden" name="tipo" value="restar">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">−</button>
                        </form>

                        <div class="px-3">{{ $item['cantidad'] }}</div>

                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center">
                            @csrf
                            <input type="hidden" name="tipo" value="sumar">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">+</button>
                        </form>
                    </div>

                    <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mt-1">Eliminar Producto</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
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
                <span id="cart-total">S/. {{ number_format($total, 2) }}</span>
            </div>
            <a href="#" class="btn btn-success mt-3 w-100">Comprar ahora</a>
        </div>
    </div>

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


        .btn-sm {
    font-size: 0.85rem;
    padding: 4px 8px;
}

    </style>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>