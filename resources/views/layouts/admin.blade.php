<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> <!-- tu propio css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> <!-- íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">Panel Admin</a>

            <div class="d-flex align-items-center">
                <span class="text-white me-3">Bienvenido, {{ Auth::user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="bg-dark text-center text-white mt-5 p-3">
        &copy; {{ date('Y') }} Botica - Administración
    </footer>
</body>
</html>
