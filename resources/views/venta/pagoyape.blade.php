<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con Yape</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .summary-box {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }
        h2, h5 {
            color: #6f42c1; /* morado */
            font-weight: bold;
        }
        .btn-yape {
            background-color: #6f42c1;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 10px;
        }
        .btn-yape:hover {
            background-color: #5a379f;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <h2 class="text-center mb-5">
            Pago con Yape
        </h2>

        <div class="row g-4">
            <!-- Resumen de pedido -->
            <div class="col-md-6">
                <div class="summary-box">
                    <h5>Resumen de pedido</h5>
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
                                <small class="text-muted">Cantidad: {{ $item['cantidad'] }}</small>
                                <div class="text-danger fw-semibold">S/ {{ number_format($subtotal, 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No hay productos en el carrito.</p>
                    @endforelse

                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <span class="text-danger fw-bold">S/ {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- QR + Upload -->
            <div class="col-md-6">
                <div class="summary-box text-center">
                    <h5>Escanea y paga con Yape</h5>
                    <p class="text-muted">Escanea este código QR con tu app Yape:</p>
                    <img src="{{ asset('./imagenes/yapeqr.jpg') }}" alt="QR Yape" style="max-width: 250px;" class="mb-3">

                    <form id="formYape" action="{{ route('checkout.yape.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label">Sube la captura de tu pago:</label>
                            <input type="file" name="voucher" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-yape w-100">
                            Enviar comprobante
                        </button>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary w-100">
                            Volver a la tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById("formYape").addEventListener("submit", function(e) {
    e.preventDefault(); // Evita que se envíe de inmediato

    Swal.fire({
        title: 'Compra con Yape',
        text: 'No se te cobrará comisión por este método.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#6f42c1',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Aceptar y enviar'   
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit(); // recién envía el formulario al backend
        }
    });
});

    </script>

    <!-- Mostrar alertas según session -->
    @if (session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#6f42c1',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            title: 'Error',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Reintentar'
        });
    </script>
    @endif

</body>
</html>
