<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Finalizar compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-banner {
            background-color: #fff;
            padding: 15px 30px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-banner img.logo {
            height: 30px;
        }

        .top-banner .secure-text {
            font-size: 0.95rem;
            color: #333;
        }

        .top-banner .secure-text i {
            margin-left: 8px;
            color: #198754;
        }

        .form-section,
        .summary-box {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .form-control::placeholder {
            font-size: 0.9rem;
            color: #adb5bd;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-check-label a {
            color: #0d6efd;
            text-decoration: underline;
        }

        .form-check-label a:hover {
            text-decoration: none;
        }

        .summary-box h6 {
            font-weight: 700;
        }

        .total {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .btn-danger {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
        }

        .divider-line {
            height: 1px;
            background-color: #dee2e6;
            margin: 20px 0;
        }

        .alert img {
            border-radius: 12px;
        }

        ul.list-unstyled li {
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .top-banner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="top-banner">
        <div class="d-flex align-items-center">
            <img src="{{ asset('imagenes/botica2.png') }}" alt="Botica Mirian" class="logo me-2">
            <strong class="fs-5">Botica Mirian</strong>
        </div>
        <div class="secure-text">
            Su compra en Botica Mirian es 100% segura
            <i class="bi bi-shield-lock-fill"></i>
        </div>
    </div>

    <div class="container py-4">
        <a href="{{ route('carrito.ver') }}" class="text-primary d-inline-block mb-3">
            <i class="bi bi-arrow-left"></i> Volver al carrito
        </a>

        <div class="row g-4">
            <!-- Formulario -->
            <div class="col-md-8">
                <div class="form-section">
                    <h4 class="mb-3 fw-bold">¡Ya falta poco para finalizar tu compra!</h4>
                    <p class="text-muted mb-4">
                        Estos datos no se guardarán para una próxima compra. Puedes continuar o <a href="#">iniciar
                            sesión</a>.
                    </p>

                    <!-- Dentro de tu vista: resources/views/ventas/checkout.blade.php -->
                    <!-- Solo reemplaza todo el formulario dentro del div .form-section por esto: -->

                    <form id="formCheckout" method="POST" novalidate>


                        @csrf
                        @php
                            $cliente = auth()->check() ? auth()->user()->cliente : null;
                        @endphp

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombres *</label>
                                <input type="text" class="form-control" name="nombres" required placeholder="Ej: Renato"
                                    value="{{ $cliente?->nombre ?? (auth()->user()->name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido paterno *</label>
                                <input type="text" class="form-control" name="apellido_paterno" required
                                    placeholder="Ej: Salas" value="{{ $cliente?->apellido_paterno ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido materno *</label>
                                <input type="text" class="form-control" name="apellido_materno" required
                                    placeholder="Ej: Torres" value="{{ $cliente?->apellido_materno ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo electrónico *</label>
                                <input type="email" class="form-control" name="correo" required
                                    placeholder="Ej: correo@dominio.com"
                                    value="{{ $cliente?->email ?? (auth()->user()->email ?? '') }}">
                            </div>
                            <!-- Campo tipo documento -->
                            <div class="col-md-6">
                                <label class="form-label">Tipo de documento</label>
                                <select class="form-select" name="tipo_documento_id" id="tipo_documento" required>
                                    <option value="" disabled @if (empty($cliente?->tipo_documento_id) && empty(optional(auth()->user())->tipo_documento_id)) selected @endif>
                                        Seleccione tipo de documento
                                    </option>
                                    @foreach ($tiposDocumento as $tipo)
                                        <option value="{{ $tipo->id }}" @if (($cliente?->tipo_documento_id ?? optional(auth()->user())->tipo_documento_id) == $tipo->id) selected @endif>
                                            {{ $tipo->nombre_documento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Nro documento -->
                            <div class="col-md-6">
                                <label class="form-label">Nro. de documento *</label>
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                    required placeholder="Ej: 12345678" value="{{ $cliente?->DNI ?? '' }}">
                            </div>
                            <!-- Celular -->
                            <div class="col-md-6">
                                <label class="form-label">Celular *</label>
                                <input type="text" class="form-control" id="celular" name="celular" required
                                    placeholder="Ej: 999000000" maxlength="9" value="{{ $cliente?->telefono ?? '' }}">
                            </div>

                        </div>

                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="termsCheck" required>
                            <label for="termsCheck" class="form-check-label">
                                He leído y acepto el
                                <a href="#" data-bs-toggle="modal" data-bs-target="#datosModal">
                                    tratamiento de mis datos personales
                                </a>.
                            </label>
                        </div>

                        <hr class="my-4">

                        <!-- Dirección o sucursal -->
                        <h6><i class="bi bi-geo-alt-fill text-danger me-2"></i> Elige ubicación de recojo del producto
                        </h6>
                        <div class="mb-3">
                            <select class="form-select" name="sucursal_id" required>
                                <option value="" disabled selected>Elige la dirección más cercana</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->direccion }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Datos ocultos del carrito -->
                        @foreach ($carrito as $item)
                            <input type="hidden" name="productos[{{ $item['id'] }}][cantidad]"
                                value="{{ $item['cantidad'] }}">
                        @endforeach


                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="finalTermsCheck" required>
                            <label for="finalTermsCheck" class="form-check-label">
                                Acepto los
                                <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">Términos y
                                    Condiciones</a>
                                y la
                                <a href="#" data-bs-toggle="modal" data-bs-target="#privacidadModal">Política de
                                    Privacidad</a>.
                            </label>
                        </div>


                    </form>
                </div>
            </div>

            <!-- Resumen de pedido -->
            <div class="col-md-4">
                <div class="summary-box">
                    <h6>Resumen de pedido</h6>
                    <hr>

                    @php
                        $carrito = session('carrito', []);
                        $total = 0;
                    @endphp

                    @forelse ($carrito as $item)
                        @php
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        @endphp
                        <div class="d-flex mb-3">
                            <img src="{{ $item['imagen'] ?? 'https://via.placeholder.com/60' }}" class="me-2"
                                style="width: 60px; height: 60px; object-fit: contain;">
                            <div>
                                <strong class="d-block">{{ $item['nombre'] }}</strong>
                                <small class="text-muted">{{ $item['presentacion'] ?? '' }}</small><br>
                                <small class="text-muted">Cantidad: {{ $item['cantidad'] }}</small>
                                <div class="text-danger fw-semibold">S/ {{ number_format($subtotal, 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No hay productos en el carrito.</p>
                    @endforelse

                    @php
                        /**
                         * CÁLCULOS ALINEADOS CON EL CONTROLADOR (fórmula inversa usada ahí)
                         *
                         * Por el controlador que tienes:
                         * $porcentaje = 0.0349; // 3.49%
                         * $igv = 1.18;          // IGV aplicado sobre la comisión
                         * $fijo = 1.18;         // monto fijo en soles
                         *
                         * totalConComision = round( (subtotal + fijo) / (1 - (porcentaje * igv)), 2 )
                         * comision = totalConComision - subtotal
                         */
                        $porcentaje = 0.0349;
                        $igv = 1.18;
                        $fijo = 1.18;

                        if ($total > 0) {
                            $totalConComision = round(($total + $fijo) / (1 - $porcentaje * $igv), 2);
                            $comision = round($totalConComision - $total, 2);
                        } else {
                            $totalConComision = 0.0;
                            $comision = 0.0;
                        }
                    @endphp

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>S/ {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Comisión</span>
                        <span>S/ {{ number_format($comision, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <span class="text-danger fw-bold">S/ {{ number_format($totalConComision, 2) }}</span>
                    </div>

                    <div class="mt-4">
                        <button type="button" id="btnComprar" class="btn btn-danger w-100"
                            onclick="validarFormulario();">
                            Comprar ahora
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Modal Tratamiento de Datos -->
    <div class="modal fade" id="datosModal" tabindex="-1" aria-labelledby="datosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="datosLabel">Tratamiento de Datos Personales</h5>
                    <!-- X en negro -->
                    <button type="button" class="btn-close" style="filter: brightness(0);"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>
                        En <strong>Botica Mirian</strong> respetamos la Ley de Protección de Datos Personales (Ley N°
                        29733).
                        Los datos que nos brindes serán utilizados únicamente para procesar tu compra, brindarte el
                        servicio
                        y mejorar tu experiencia.
                    </p>
                    <ul>
                        <li>No compartimos tus datos con terceros sin tu consentimiento.</li>
                        <li>Puedes solicitar la actualización o eliminación de tu información en cualquier momento.</li>
                        <li>Implementamos medidas de seguridad para proteger tu privacidad.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Términos y Condiciones -->
    <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="terminosLabel">Términos y Condiciones</h5>
                    <!-- X en negro -->
                    <button type="button" class="btn-close" style="filter: brightness(0);"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>
                        Al comprar en <strong>Botica Mirian</strong> aceptas los siguientes términos:
                    </p>
                    <ul>
                        <li>Los precios y promociones están sujetos a cambios sin previo aviso.</li>
                        <li>La venta de medicamentos se realiza según normativa vigente en Perú.</li>
                        <li>Los productos estarán disponibles de acuerdo al stock de cada sucursal.</li>
                        <li>No se permite el uso indebido de la plataforma con fines fraudulentos.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Política de Privacidad -->
    <div class="modal fade" id="privacidadModal" tabindex="-1" aria-labelledby="privacidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="privacidadLabel">Política de Privacidad</h5>
                    <!-- X en negro -->
                    <button type="button" class="btn-close" style="filter: brightness(0);"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>
                        En <strong>Botica Mirian</strong> valoramos tu privacidad:
                    </p>
                    <ul>
                        <li>La información proporcionada se usará exclusivamente para gestionar tus pedidos.</li>
                        <li>No venderemos ni compartiremos tus datos con terceros sin autorización.</li>
                        <li>Nos comprometemos a proteger tu información con altos estándares de seguridad.</li>
                    </ul>
                    <p>
                        Al continuar con tu compra, aceptas nuestra política de privacidad.
                    </p>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script>
        function validarFormulario() {
            const formulario = document.getElementById('formCheckout');
            const celular = document.getElementById("celular").value.trim();
            const numeroDoc = document.getElementById("numero_documento").value.trim();
            const tipoDoc = document.getElementById("tipo_documento");

            // Validar celular
            if (celular.length !== 9) {
                alert("El número de celular debe tener 9 dígitos.");
                return;
            }

            // Validar documento según tipo
            let selected = tipoDoc.options[tipoDoc.selectedIndex]?.text?.toLowerCase() || "";
            if ((selected.includes("dni") || selected.includes("carnet")) && numeroDoc.length !== 8) {
                alert("El número de documento debe tener 8 dígitos.");
                return;
            }

            // Validación HTML5 normal
            if (!formulario.checkValidity()) {
                formulario.reportValidity();
                return;
            }

            // Si todo está OK -> enviar
            const formData = new FormData(formulario);

            fetch("{{ route('checkout.guardar-datos') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData,
                credentials: 'same-origin'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.init_point) {
                        window.location.href = data.init_point; // Redirige a Mercado Pago
                    } else if (data.mensaje) {
                        alert(data.mensaje);
                    } else if (data.error) {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error al enviar los datos:', error);
                    alert("Error al enviar los datos. Revisa la consola.");
                });
        }

        // Forzar solo números y máximo de dígitos
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("celular").addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").slice(0, 9); // solo números y máx 9 dígitos
            });

            document.getElementById("numero_documento").addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").slice(0, 8); // solo números y máx 8 dígitos
            });
        });
    </script>


    <!-- Bootstrap 5 JS (necesario para que funcionen los modales, dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>




</body>


</html>