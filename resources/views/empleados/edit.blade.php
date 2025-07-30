@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    <h3 class="fw-semibold">Editar Empleado</h3>

    <div class="card shadow p-4 mt-3 rounded-4 custom-shadow">
        <form method="POST" action="{{ route('empleados.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Datos personales --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" id="name" name="name" placeholder="Nombre" value="{{ old('name', $user->name) }}">
                        <label for="name">Nombre</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno" value="{{ old('apellido_paterno', $user->cliente->apellido_paterno ?? '') }}">
                        <label for="apellido_paterno">Apellido Paterno</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno" value="{{ old('apellido_materno', $user->cliente->apellido_materno ?? '') }}">
                        <label for="apellido_materno">Apellido Materno</label>
                    </div>
                </div>
            </div>

            {{-- Tipo de documento y número --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipo_documento_id" class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento_id" id="tipo_documento_id" class="form-select" required>
                        <option value="" disabled>Seleccione...</option>
                        @foreach($tiposDocumento as $tipo)
                            <option value="{{ $tipo->id }}" data-nombre="{{ $tipo->nombre_documento }}"
                                {{ old('tipo_documento_id', $user->tipo_documento_id) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre_documento }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="DNI" id="DNI" placeholder="Número de Documento" 
                               value="{{ old('DNI', $user->cliente->DNI ?? '') }}" {{ $user->tipoDocumento ? '' : 'disabled' }}>
                        <label for="DNI">Número de Documento</label>
                        <small id="dniHelp" class="form-text text-muted"></small>
                    </div>
                </div>
            </div>

            {{-- Dirección y teléfono --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="direccion" id="direccion" placeholder="Dirección" value="{{ old('direccion', $user->cliente->direccion ?? '') }}">
                        <label for="direccion">Dirección</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="telefono" id="telefono" placeholder="Teléfono" value="{{ old('telefono', $user->cliente->telefono ?? '') }}">
                        <label for="telefono">Teléfono</label>
                    </div>
                </div>
            </div>

            {{-- Email y contraseña --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control styled-input" name="email" id="email" placeholder="Correo electrónico" value="{{ old('email', $user->email) }}">
                        <label for="email">Correo electrónico</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control styled-input" name="password" id="password" placeholder="Contraseña (opcional)">
                        <label for="password">Contraseña (opcional)</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control styled-input" name="password_confirmation" id="password_confirmation" placeholder="Confirmar contraseña">
                        <label for="password_confirmation">Confirmar contraseña</label>
                    </div>
                </div>
            </div>

            {{-- Rol --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="rol_id" class="form-label">Rol</label>
                    <select name="rol_id" id="rol_id" class="form-select" required>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id', $user->rol_id) == $rol->id ? 'selected' : '' }}>
                                {{ ucfirst($rol->tipo) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Estado del empleado --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select" required>
            <option value="1" {{ old('estado', $user->estado) == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ old('estado', $user->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>


            {{-- Botón --}}
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" >Actualizar Empleado</button>
            </div>
        </form>
    </div>
</div>

{{-- Script para habilitar/validar DNI --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tipoDocumentoSelect = document.getElementById('tipo_documento_id');
        const dniInput = document.getElementById('DNI');
        const dniHelp = document.getElementById('dniHelp');

        function toggleDniInput() {
            const selectedOption = tipoDocumentoSelect.options[tipoDocumentoSelect.selectedIndex];
            const nombreDocumento = selectedOption.getAttribute('data-nombre');

            dniInput.disabled = false;

            if (nombreDocumento === 'DNI') {
                dniInput.maxLength = 8;
                dniInput.placeholder = "Ingrese 8 dígitos";
                dniHelp.textContent = "Debe ingresar 8 dígitos para el DNI.";
                dniInput.pattern = "\\d{8}";
            } else if (nombreDocumento === 'Carnet de extranjería') {
                dniInput.maxLength = 12;
                dniInput.placeholder = "Ingrese hasta 12 caracteres";
                dniHelp.textContent = "Puede ingresar hasta 12 caracteres (letras o números).";
                dniInput.removeAttribute("pattern");
            } else {
                dniInput.disabled = true;
                dniInput.value = '';
                dniInput.placeholder = "";
                dniHelp.textContent = "";
                dniInput.removeAttribute("pattern");
            }
        }

        tipoDocumentoSelect.addEventListener('change', toggleDniInput);
        toggleDniInput(); // Ejecutar al cargar por si ya está seleccionado
    });
</script>

@endsection
