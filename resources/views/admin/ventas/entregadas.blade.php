@extends('layouts.admin')

@section('content')

<div class="container">

    {{-- Título --}}
    <h4 class="mb-4">
        <span style="font-size: 1.5rem; margin-right: 10px;">✅</span>
        <strong>Listado de Ventas Entregadas</strong>
    </h4>

    {{-- Encabezado tipo productos (barra de búsqueda y botón) --}}
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap align-items-center gap-2">
            <select class="form-select" style="max-width: 250px;">
                <option selected>Seleccione una opción</option>
                <option value="1">Por cliente</option>
                <option value="2">Por documento</option>
                <option value="3">Por fecha</option>
            </select>

            <input type="text" class="form-control" placeholder="Buscar" style="max-width: 250px;">

            <button class="btn btn-success">
                <i class="bi bi-search"></i>
            </button>

            <button class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Limpiar
            </button>

            <a href="{{ route('admin.ventas.pendientes') }}" class="btn btn-outline-secondary ms-auto">
                <i class="bi bi-clock"></i> Ver ventas pendientes
            </a>
        </div>
    </div>

    {{-- Lista de ventas entregadas --}}
    @if ($ventas->count() > 0)
    @foreach ($ventas as $venta)
    <div class="card mb-4 shadow-sm border border-success">
        <div class="card-header bg-success-subtle d-flex justify-content-between align-items-center">
            <div>
                <strong>Venta #{{ $venta->id }}</strong> |
                Cliente: {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }} |
                Documento: {{ $venta->cliente->tipoDocumento->nombre_documento ?? 'Sin documento' }} - {{ $venta->cliente->DNI }}
            </div>
            <div>
                <span class="badge bg-success">
                    {{ $venta->estadoVenta->estado ?? 'Entregada' }}
                </span>
            </div>
        </div>

        <div class="card-body bg-light">
            <p class="mb-1"><strong>Total:</strong> S/ {{ number_format($venta->total, 2) }}</p>
            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</p>
            <p class="mb-3"><strong>Estado:</strong>
                <span class="badge bg-success text-white">
                    {{ $venta->estadoVenta->estado ?? 'Entregada' }}
                </span>
            </p>

            <div class="bg-white p-3 rounded border">
                <strong>Productos:</strong>
                <ul class="mb-0">
                    @foreach ($venta->detalleVentas as $detalle)
                    <li>{{ $detalle->producto->nombre }} - Cantidad: {{ $detalle->cantidad }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-info">No hay ventas entregadas aún.</div>
    @endif

    {{-- Paginación --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $ventas->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection