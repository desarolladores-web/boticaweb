@php
    $layout = auth()->check() && auth()->user()->is_admin ? 'layouts.admin' : 'layouts.app';
@endphp

@extends($layout)
@section('body-class', 'page-edit')

@section('content')
    <div class="container">
        @vite(['resources/css/edit.css'])
        <div class="row">
            <!-- Sidebar principal -->
            <div class="col-12 col-lg-3">
                <div class="user-sidebar">
                    <!-- Imagen del avatar -->
                    <div class="avatar text-center">
                        @if ($user && $user->imagen)
                            <!-- Si el usuario tiene una imagen -->
                            <img src="data:image/jpeg;base64,{{ base64_encode($user->imagen) }}" alt="Avatar"
                                class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <!-- Si no tiene imagen, mostramos la inicial del nombre en un círculo con el mismo estilo -->
                            <div class="rounded-circle"
                                style="width: 60px; height: 60px; background-color: #0cb1b1; color: white; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; margin: 0 auto;">
                                {{ strtoupper(substr($user->name, 0, 1)) }} <!-- Mostramos la inicial del nombre -->
                            </div>
                        @endif
                        <h5 class="mt-2">Hola <span class="ms-2">{{ $user->name }}</span></h5>
                        <!-- Nombre del usuario -->
                        <p class="text-muted" style="font-size: 14px;">{{ $user->email }}</p>
                        <!-- Correo electrónico del usuario -->
                    </div>

                    <!-- Menú de navegación -->
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="{{ route('account.edit', ['section' => 'profile']) }}" class="sidebar-link">
                                <i class="bi bi-pen" style="margin-right: 10px;"></i> <span>Editar perfil</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('account.password.edit', ['section' => 'profile']) }}" class="sidebar-link">
                                <i class="bi bi-shield-lock" style="margin-right: 10px;"></i> <span>Contraseña</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('account', 'pedidos') }}" class="sidebar-link">
                                <i class="bi bi-box" style="margin-right: 10px;"></i> <span>Pedidos</span>
                            </a>
                        </li>
                        </li>
                        <li class="mb-3">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> <span>Cerrar sesión</span>
                            </a>
                        </li>

                        <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                        </a>


                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9">
                <div class="account-card-box addresses-box">
                    <!-- Mensajes de éxito y error -->

                    <!--@if (session('success'))
    <div class="alert alert-success mt-4">
                              {{ session('success') }}
                            </div>
    @endif-->
                    @if (session('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="account-card-title d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ __('Editar') }} </span>
                    </div>

                    <!-- Mostrar contenido dinámico -->
                    @if ($section == 'profile')
                        @include('account.edit_profile') <!-- Formulario para editar perfil -->
                    @elseif($section == 'password')
                        @include('account.edit_password') <!-- Formulario para editar contraseña -->
                    @elseif($section == 'pedidos')
                        @include('account.pedidos') <!-- Vista de pedidos -->
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
