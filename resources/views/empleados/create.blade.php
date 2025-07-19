@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="fw-semibold">Registrar Nuevo Empleado</h3>

<!--@if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    <!-- Contenedor con sombra y bordes redondeados -->
    <div class="card shadow p-4 mt-3 rounded-4 custom-shadow">
        <form method="POST" action="{{ route('empleados.store') }}">
            @csrf

            <!-- Nombre -->
            <div class="form-floating mb-3">
                <input
                    type="text"
                    class="form-control styled-input"
                    id="name"
                    name="name"
                    placeholder="Nombre"
                >
                <label for="name">Nombre</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control styled-input"
                    id="email"
                    name="email"
                    placeholder="Correo"
                >
                <label for="email">Correo</label>
            </div>

            <!-- Contraseña -->
            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control styled-input"
                    id="password"
                    name="password"
                    placeholder="Contraseña"
                >
                <label for="password">Contraseña</label>
            </div>

            <!-- Confirmar contraseña -->
            <div class="form-floating mb-4">
                <input
                    type="password"
                    class="form-control styled-input"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirmar Contraseña"
                >
                <label for="password_confirmation">Confirmar Contraseña</label>
            </div>

            <!-- Botón -->
            <div class="d-flex ">
                <button type="submit"  >
                    Crear Cuenta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

