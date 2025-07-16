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
                        Estos datos no se guardarán para una próxima compra. Puedes continuar o <a href="#">iniciar sesión</a>.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombres *</label>
                            <input type="text" class="form-control" placeholder="Ej: Renato">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido paterno *</label>
                            <input type="text" class="form-control" placeholder="Ej: Salas">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido materno *</label>
                            <input type="text" class="form-control " placeholder="Ej: Salas">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo electrónico *</label>
                            <input type="email" class="form-control" placeholder="Ej: correo@dominio.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de documento</label>
                            <select class="form-select">
                                <option>DNI</option>
                                <option>CE</option>
                                <option>Pasaporte</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nro. de documento *</label>
                            <input type="text" class="form-control" placeholder="Ej: 12345678">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Celular *</label>
                            <input type="text" class="form-control" placeholder="Ej: 999 000 000">
                        </div>
                    </div>

                    <div class="form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="termsCheck">
                        <label for="termsCheck" class="form-check-label">
                            He leído y acepto el <a href="#">tratamiento de mis datos personales</a> para finalidades adicionales.
                        </label>
                    </div>

                    <hr class="my-4">

                    <h6 class="d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i> Elige ubicación de recojo del producto
                    </h6>
                    <div class="mb-3">
                        <select class="form-select">
                            <option selected disabled>Elige la dirección más cercana a tu ubicación actual</option>
                            <option>Av. Caracas 498, Ica 11002, La Tinguiña</option>
                            <option>Av. México 156, Ica 11002, La Tinguiña</option>
                        </select>
                    </div>

                    <h6 class="d-flex align-items-center">
                        <i class="bi bi-receipt-cutoff text-primary me-2"></i> Solicita un comprobante de pago
                    </h6>
                    <p class="text-muted">Activa esta opción si deseas que te enviemos factura, de lo contrario te enviaremos boleta.</p>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="toggleFactura">
                        <label class="form-check-label" for="toggleFactura">Solicitar factura</label>
                    </div>

                    <div id="facturaFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ruc" class="form-label">RUC (11 dígitos)</label>
                                <input type="text" class="form-control" id="ruc" placeholder="Ingresa el RUC">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="razon" class="form-label">Razón social</label>
                                <input type="text" class="form-control" id="razon" placeholder="Ingresa la razón social">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio legal</label>
                            <input type="text" class="form-control" id="domicilio" placeholder="Ingresa el domicilio legal">
                        </div>
                    </div>

                    <div class="alert alert-light border mt-4 text-center">
                        <img src="https://images.ctfassets.net/l9x8e72nkkav/494Fyn6il5sHcMjjd0928N/59a8b7ea6202d5d6a06277a935955079/PagaSeguro-mifarma-bx2beneficos-web__1_.jpg"
                            alt="Banner Confianza" class="img-fluid">
                    </div>

                    <h6 class="mt-4">Comprueba tus datos antes de finalizar tu compra</h6>
                    <ul class="list-unstyled small">
                        <li>📄 Datos personales: -</li>
                        <li>🏥 Despachado por: Botica Mirian</li>
                        <li>🚚 Tipo de entrega: -</li>
                        <li>🕒 Fecha y hora de entrega: -</li>
                        <li>💳 Comprobante de pago: </li>
                        <li>🧾 Medio de pago: -</li>
                    </ul>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="finalTermsCheck">
                        <label for="finalTermsCheck" class="form-check-label">
                            He leído y acepto los <a href="#">Términos y Condiciones</a> y las <a href="#">Políticas de Privacidad</a>
                        </label>
                    </div>
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
                            <img src="{{ $item['imagen'] ?? 'https://via.placeholder.com/60' }}" class="me-2" style="width: 60px; height: 60px; object-fit: contain;">
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

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>S/ {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <span class="text-danger fw-bold">S/ {{ number_format($total, 2) }}</span>
                    </div>

                    <form action="#" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Comprar ahora</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById('toggleFactura');
            const fields = document.getElementById('facturaFields');

            toggle.addEventListener('change', function () {
                fields.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>
