@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    <h3 class="fw-semibold">Registrar Nuevo Empleado</h3>

    <div class="card shadow p-4 mt-3 rounded-4 custom-shadow">
        <form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Datos personales --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" id="name" name="name" placeholder="Nombre">
                        <label for="name">Nombre</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno">
                        <label for="apellido_paterno">Apellido Paterno</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno">
                        <label for="apellido_materno">Apellido Materno</label>
                    </div>
                </div>
            </div>

            {{-- Tipo de documento y número --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipo_documento_id" class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento_id" id="tipo_documento_id" class="form-select" required>
                        <option value="" disabled selected>Seleccione...</option>
                        @foreach($tiposDocumento as $tipo)
                            <option value="{{ $tipo->id }}" data-nombre="{{ $tipo->nombre_documento }}">
                                {{ $tipo->nombre_documento }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="DNI" id="DNI" disabled placeholder="Número de Documento">
                        <label for="DNI">Número de Documento</label>
                        <small id="dniHelp" class="form-text text-muted"></small>
                    </div>
                </div>
            </div>

            {{-- Dirección y teléfono --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="direccion" id="direccion" placeholder="Dirección">
                        <label for="direccion">Dirección</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control styled-input" name="telefono" id="telefono" placeholder="Teléfono">
                        <label for="telefono">Teléfono</label>
                    </div>
                </div>
            </div>

            {{-- Email y contraseña --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control styled-input" name="email" id="email" placeholder="Correo electrónico">
                        <label for="email">Correo electrónico</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control styled-input" name="password" id="password" placeholder="Contraseña">
                        <label for="password">Contraseña</label>
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
                            <option value="{{ $rol->id }}">{{ ucfirst($rol->tipo) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Botón --}}
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary px-4">Registrar Empleado</button>
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

        tipoDocumentoSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
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
        });
    });
</script>

@endsection
