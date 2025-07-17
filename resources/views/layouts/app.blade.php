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

    @stack('styles')



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
                                        <a class="nav-link" href="{{ route('quienes.somos') }}">Quienes somos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('consejos') }}">Consejos</a>
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
                            <input type="text" class="form-control" name="keyword" placeholder="Buscar"
                                value="{{ request('keyword') }}">
                            <button type="submit" class="btn"><i class="bi bi-search"></i></button>
                        </form>

                        <div class="icons">
                            <div class="item">
                                <div class="dropdown account-icon">
                                    <!-- Ícono de usuario y nombre del cliente al lado -->
                                    <a class="btn dropdown-toggle px-0 d-flex align-items-center" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <!-- Si el usuario está autenticado, mostramos la imagen de perfil -->
                                        @auth
                                            @if(Auth::user()->imagen)
                                                <img src="data:image/jpeg;base64,{{ base64_encode(Auth::user()->imagen) }}"
                                                    alt="Avatar" class="rounded-circle"
                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                                <!-- Icono por defecto si no tiene imagen -->
                                            @endif
                                            <span class="ms-2">{{ Auth::user()->name }}</span>
                                            <!-- Nombre del usuario autenticado -->
                                        @else
                                            <!-- Si el usuario no está autenticado, mostramos el icono de perfil -->
                                            <i class="bi bi-person" style="font-size: 1.5rem;"></i>

                                        @endauth
                                    </a>





                                    <!-- Menú desplegable -->
                                    <!-- Menú desplegable -->
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @guest
                                            @if (Route::has('login'))
                                                <a class="dropdown-item"
                                                    href="{{ route('login') }}">{{ __('Inicia Sesión') }}</a>
                                            @endif

                                            @if (Route::has('register'))
                                                <a class="dropdown-item"
                                                    href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                            @endif
                                        @else
                                            @php
                                                $user = Auth::user();
                                            @endphp

                                            <!-- Mi cuenta con ícono -->
                                            @if ($user->rol_id == 1)
                                                <!-- Admin -->
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                    <i class="bi bi-person me-2"></i> Panel Admin
                                                </a>
                                                <a class="dropdown-item" href="{{ route('account.edit') }}">
                                                    <i class="bi bi-person me-2"></i> EDITAR
                                                </a>
                                            @else
                                                <!-- Usuario normal -->
                                                <a class="dropdown-item" href="{{ route('account.edit') }}">
                                                    <i class="bi bi-person me-2"></i> Mi Cuenta
                                                </a>
                                            @endif

                                            <!-- Pedidos -->
                                            <a class="dropdown-item" href="#">Pedidos</a>

                                            <!-- Favoritos -->
                                            <a class="dropdown-item" href="#">Favoritos</a>

                                            <!-- Cerrar sesión -->
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right"></i> {{ __('Cerrar sesión') }}
                                            </a>

                                            <!-- Formulario de cierre de sesión -->
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        @endguest
                                    </div>

                                </div>
                            </div>
                        </div>




                        @php
                            $carrito = session('carrito', []);
                            $cantidadTotal = count($carrito);
                        @endphp

                        <div class="item ms-4">
                            <a href="#" class="header-cart-icon position-relative">
                                <i class="bi bi-cart-fill" style="font-size: 1.5rem; color:black;"></i>
                                <span
                                    class="icon-quantity position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
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

    <main>
        @yield('content')
    </main>
    @include('layouts.whatsapp')
    @include('layouts.footer')
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

            @if(count($carrito) > 0)
                @foreach($carrito as $id => $item)
                    <div class="mb-3 border-bottom pb-3">
                        <div class="d-flex align-items-center">
                            @if($item['imagen'])
                                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="me-3 cart-img">
                            @endif

                            <div class="flex-grow-1 ps-2">
                                <div class="fw-bold">{{ $item['nombre'] }}</div>
                                @php $subtotal = $item['precio'] * $item['cantidad']; @endphp
                                <div class="text-danger fw-semibold mb-2">S/ {{ number_format($subtotal, 2) }}</div>

                                <div class="d-flex align-items-center mb-2" style="width: fit-content;">
                                    <form method="POST" action="{{ route('carrito.actualizar', $id) }}"
                                        class="d-flex align-items-center me-1">
                                        @csrf
                                        <input type="hidden" name="tipo" value="restar">
                                        <input type="hidden" name="desde_sidebar" value="1">
                                        <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm px-2">−</button>
                                    </form>

                                    <div class="px-3">{{ $item['cantidad'] }}</div>

                                    <form method="POST" action="{{ route('carrito.actualizar', $id) }}"
                                        class="d-flex align-items-center ms-1">
                                        @csrf
                                        <input type="hidden" name="tipo" value="sumar">
                                        <input type="hidden" name="desde_sidebar" value="1">
                                        <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm px-2">+</button>
                                    </form>
                                </div>

                                <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="desde_sidebar" value="1">
                                    <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
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
                <span class="text-success" id="cart-total">S/. {{ number_format($total, 2) }}</span>
            </div>
            <a href="{{ route('ventas.create', ['total' => $total]) }}" class="btn btn-danger mt-3 w-100">Comprar
                ahora</a>
        </div>

        <a href="{{ route('carrito.ver') }}"
            class="button w-100 d-flex align-items-center justify-content-center text-decoration-none"
            style="font-size: 12px; font-weight: 100; padding: 25px;">
            Ver carrito
            <span class="iconify ms-2" data-icon="bi:cart-check-fill" style="font-size: 20px;"></span>
        </a>
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
</body>

</html>