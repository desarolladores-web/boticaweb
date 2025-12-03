@extends('layouts.app')
@vite(['resources/css/login.css'])

@section('content')
    <div class="container my-5">
        <!-- Card responsivo -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="row g-0 align-items-center">

                <!-- Left side: Imagen y bienvenida -->
                <div class="login-right">
                    <img src="{{ asset('imagenes/login.png') }}" alt="Welcome Image"
                        style="width: 400px; margin-bottom: 20px;">
                    <h2>¿Eres nuevo aquí?</h2>
                    <p>¡Regístrate y descubre una gran cantidad de nuevas oportunidades!</p>
                    <a href="{{ route('register') }}" class="btn">Registrarse</a>
                </div>
                <!-- Right side: login form -->
                <div class="col-12 col-md-6 p-4">
                    <h1 class="text-center mb-4">Iniciar sesión en su cuenta</h1>

                    <div class="divider"><span></span></div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-person me-2"></i> {{ __('Ingresa tus datos') }}
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Correo" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="password" type="password" placeholder="Contraseña"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Mantener sesión iniciada') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg rounded-pill shadow-sm fw-semibold"
                                style="background-color: #c62828; color: white;">
                                <i class="bx bx-log-in-circle me-2"></i> {{ __('Iniciar sesión') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link mt-3 d-block text-center" href="{{ route('password.request') }}">
                                <!--  {{ __('¿Olvidaste tu contraseña?') }} -->
                            </a>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
