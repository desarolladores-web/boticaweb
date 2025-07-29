@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-5">
            <div class="border rounded p-3 bg-white shadow-sm">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid w-100 rounded" alt="{{ $producto->nombre }}">
                @else
                    <img src="https://via.placeholder.com/400x400?text=Sin+Imagen" class="img-fluid w-100 rounded" alt="Sin Imagen">
                @endif
            </div>
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-7">
            <div class="bg-white p-4 rounded shadow-sm">
                <h2 class="fw-bold mb-3">
                    <i class="bi bi-capsule me-2"></i>{{ $producto->nombre }}
                </h2>
                <p class="text-muted mb-4">
                    <i class="bi bi-file-earmark-text me-2"></i>{{ $producto->descripcion }}
                </p>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><i class="bi bi-coin me-2"></i><strong>Precio:</strong> S/. {{ number_format($producto->pvp1, 2) }}</li>
                    
                    <li class="list-group-item"><i class="bi bi-eyedropper me-2"></i><strong>Principio Activo:</strong> {{ $producto->principio_activo ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="bi bi-box-seam me-2"></i><strong>Stock disponible:</strong> {{ $producto->stock }}</li>
                  
                    <li class="list-group-item"><i class="bi bi-calendar-event me-2"></i><strong>Fecha de vencimiento:</strong> {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}</li>
                    <li class="list-group-item"><i class="bi bi-bag me-2"></i><strong>Presentación:</strong> {{ $producto->presentacion->tipo_presentacion ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="bi bi-tag me-2"></i><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="bi bi-building me-2"></i><strong>Laboratorio:</strong> {{ $producto->laboratorio->nombre_laboratorio ?? 'N/A' }}</li>
                </ul>

                <!-- Opciones de compra -->
                <div class="border-top pt-3">
    <h5 class="mb-3">
        <i class="bi bi-truck me-2"></i>Opciones de entrega
    </h5>
    <div class="d-flex gap-3">
        <button class="btn btn-outline-success w-50">
            <i class="bi bi-shop me-1"></i>Retiro en tienda
        </button>
        <button class="btn btn-outline-primary w-50">
            <i class="bi bi-house-door me-1"></i>Despacho a domicilio
        </button>
    </div>

    <!-- Formulario para agregar al carrito -->
    <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}" class="agregar-carrito-form mt-4">
        @csrf
        <input type="hidden" name="cantidad" value="1">
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
        </button>
    </form>
</div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
