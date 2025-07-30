@extends('layouts.app')

@section('content')
<style>
    .text-primary {
    color: #0b3b60 !important;
}
.btn-warning {
    background-color: #8a5f43ff;
    border-color: #0f0f0fff;
}
.btn-warning:hover {
    background-color: #e65c00;
}
.shadow-sm {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
}

</style>
<div class="container py-5">
    <div class="row g-5">
        <!-- Miniaturas laterales -->
        <div class="col-md-1 d-none d-md-flex flex-column gap-3">
            @for($i = 0; $i < 4; $i++)
                <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-fluid rounded border" style="cursor:pointer;">
            @endfor
        </div>

        <!-- Imagen principal -->
        <div class="col-md-4">
            <div class="bg-white border rounded p-3 shadow-sm text-center">
                @if($producto->imagen)
                    <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-fluid rounded" alt="Producto">
                @else
                    <img src="https://via.placeholder.com/400x400?text=Sin+Imagen" class="img-fluid rounded" alt="Sin Imagen">
                @endif
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-md-7">
            <div class="bg-white border rounded p-4 shadow-sm" style="font-size: 14px; color: #333;">
                <p class="text-muted mb-1" style="font-size: 13px;">TUBO {{ $producto->presentacion->tipo_presentacion ?? '' }}</p>
                <h2 class="fw-semibold mb-3" style="color: #1c1c1c; font-size: 20px;">{{ $producto->nombre }}</h2>

                <div class="mb-3">
                    <span class="text-muted text-decoration-line-through" style="font-size: 14px;">S/ {{ number_format($producto->pvp1 + 50, 2) }}</span>
                    <span class="fw-bold ms-2" style="color: #e63946; font-size: 18px;">S/ {{ number_format($producto->pvp1, 2) }}</span>
                </div>

                <!-- Precio Monedero -->
                <div class="border p-3 rounded mb-4" style="background-color: #fffbe6;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-wallet-fill text-warning fs-5 me-2"></i>
                        <div style="font-size: 13px;">
                            <strong>Inicia sesión</strong> para ahorrar 
                            <span class="text-danger">S/ 50.00</span> con el precio Monedero del Ahorro.
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush mb-4 small">
                    <li class="list-group-item"><strong>Principio Activo:</strong> {{ $producto->principio_activo ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Stock:</strong> {{ $producto->stock }}</li>
                    <li class="list-group-item"><strong>Vencimiento:</strong> {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}</li>
                    <li class="list-group-item"><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Laboratorio:</strong> {{ $producto->laboratorio->nombre_laboratorio ?? 'N/A' }}</li>
                </ul>

                <!-- Retiro en botica -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-2" style="font-size: 14px;">Método de entrega</h6>
                    <button class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center gap-2 py-2" style="font-size: 14px;">
                        <i class="bi bi-hospital fs-5"></i> Retiro en botica (Gratis)
                    </button>
                </div>

                <!-- Botón agregar al carrito -->
                <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                    @csrf
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="btn btn-warning text-white w-100 fw-semibold py-2" style="font-size: 13px;">
                        <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection