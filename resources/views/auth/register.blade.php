@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #f3f6f9;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 30px;
        }

        .register-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1180px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .register-left {
            flex: 1;
            background: linear-gradient(135deg, #1abc9c, #16a085);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .register-left img {
            width: 250px;
            max-width: 100%;
            height: auto;
            margin-bottom: 30px;
        }

        .register-left h2 {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .register-left p {
            font-size: 1.1rem;
        }

        .register-right {
            flex: 2;
            padding: 60px;
            background-color: #fff;
        }

        .card-header {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
            color: #333;
        }

        .form-control,
        .form-select {
            height: 50px;
            font-size: 1.05rem;
            border-radius: 12px;
            padding-left: 20px;
        }

        .btn-primary {
            background-color: #1abc9c;
            border: none;
            font-size: 1.1rem;
            padding: 14px 30px;
            border-radius: 30px;
        }

        .btn-primary:hover {
            background-color: #16a085;
        }

        .invalid-feedback {
            font-size: 0.9rem;
        }

        /* 🔹 Responsividad */
        @media (max-width: 992px) {
            .register-container {
                flex-direction: column;
            }

            .register-left,
            .register-right {
                flex: unset;
                width: 100%;
            }

            .register-right {
                padding: 40px 20px;
            }

            .register-left {
                padding: 40px 20px;
            }
        }

        @media (max-width: 576px) {
            .register-left h2 {
                font-size: 1.6rem;
            }

            .register-left p {
                font-size: 1rem;
            }

            .card-header {
                font-size: 1.5rem;
                margin-bottom: 25px;
            }

            .form-control,
            .form-select {
                font-size: 0.95rem;
                height: 45px;
            }

            .btn-primary {
                font-size: 1rem;
                padding: 12px 25px;
            }
        }
    </style>

    <div class="register-wrapper">
        <div class="register-container">

            <!-- Izquierda -->
            <div class="register-left">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Registro">
                <h2>¡Bienvenido!</h2>
                <p>Únete y accede a todos nuestros beneficios exclusivos.</p>
            </div>

            <!-- Derecha -->
            <div class="register-right">
                <div class="card-header">Formulario de Registro</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre</label>
                                <input id="name" type="text" placeholder="Ej: Juan"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                <input id="apellido_paterno" type="text" placeholder="Ej: Pérez"
                                    class="form-control @error('apellido_paterno') is-invalid @enderror"
                                    name="apellido_paterno" value="{{ old('apellido_paterno') }}" required>
                                @error('apellido_paterno')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                <input id="apellido_materno" type="text" placeholder="Ej: Díaz"
                                    class="form-control @error('apellido_materno') is-invalid @enderror"
                                    name="apellido_materno" value="{{ old('apellido_materno') }}" required>
                                @error('apellido_materno')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tipo_documento_id" class="form-label">Tipo de Documento</label>
                                <select id="tipo_documento_id" name="tipo_documento_id"
                                    class="form-select @error('tipo_documento_id') is-invalid @enderror" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach ($tiposDocumento as $tipo)
                                        <option value="{{ $tipo->id }}"
                                            {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre_documento }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_documento_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6" id="dni-container" style="display: none;">
                                <label for="DNI" class="form-label">Documento</label>
                                <input id="DNI" type="text" placeholder="Ej: 71234567" inputmode="numeric"
                                    pattern="[0-9]*" class="form-control @error('DNI') is-invalid @enderror" name="DNI"
                                    value="{{ old('DNI') }}">
                                @error('DNI')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input id="telefono" type="text" placeholder="Ej: 987654321"
                                    class="form-control @error('telefono') is-invalid @enderror" name="telefono"
                                    value="{{ old('telefono') }}" required>
                                @error('telefono')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input id="direccion" type="text" placeholder="Ej: Av. Los Álamos 456"
                                    class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                                    value="{{ old('direccion') }}" required>
                                @error('direccion')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" type="email" placeholder="Ej: ejemplo@email.com"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password" placeholder="Mínimo 8 caracteres"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                <input id="password-confirm" type="password" placeholder="Repite la contraseña"
                                    class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-primary px-5">Registrar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectTipoDoc = document.getElementById('tipo_documento_id');
            const dniContainer = document.getElementById('dni-container');
            const dniInput = document.getElementById('DNI');

            function toggleDNI() {
                const selectedText = selectTipoDoc.options[selectTipoDoc.selectedIndex]?.text?.toLowerCase();

                if (selectedText === 'dni') {
                    dniContainer.style.display = 'block';
                    dniInput.maxLength = 8;
                    dniInput.required = true;
                } else if (selectedText.includes('carnet')) {
                    dniContainer.style.display = 'block';
                    dniInput.maxLength = 15;
                    dniInput.required = true;
                } else {
                    dniContainer.style.display = 'none';
                    dniInput.required = false;
                    dniInput.value = '';
                }
            }

            dniInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            toggleDNI();
            selectTipoDoc.addEventListener('change', toggleDNI);
        });
    </script>
@endsection
