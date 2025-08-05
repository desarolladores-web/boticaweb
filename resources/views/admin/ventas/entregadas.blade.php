@extends('layouts.admin')

@section('content')

<div class="container">
    <h2 class="mb-4">Ventas entregadas</h2>

    <a href="{{ route('admin.ventas.pendientes') }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-clock"></i> Ver ventas pendientes
    </a>

    @if ($ventas->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Tipo de documento</th>
                    <th>N° de documento</th>
                    <th>Total (S/)</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr class="table-success">
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
                    <td>{{ $venta->cliente->tipoDocumento->nombre_documento ?? 'Sin documento' }}</td>
                    <td>{{ $venta->cliente->DNI }}</td>
                    <td>S/ {{ number_format($venta->total, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $venta->estadoVenta->estado ?? 'Sin estado' }}
                        </span>
                    </td>
                </tr>

                <!-- Productos de la venta -->
                <tr>
                    <td colspan="6">
                        <strong>Productos:</strong>
                        <ul class="mb-0">
                            @foreach ($venta->detalleVentas as $detalle)
                            <li>{{ $detalle->producto->nombre }} - Cantidad: {{ $detalle->cantidad }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">No hay ventas entregadas aún.</div>
    @endif
</div>

@endsection