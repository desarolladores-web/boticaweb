@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Ventas pendientes de entrega</h2>

    <a href="{{ route('admin.ventas.entregadas') }}" class="btn btn-outline-primary mb-4">
        <i class="bi bi-truck"></i> Ver ventas entregadas
    </a>

    @if ($ventas->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total (S/)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                    <td>S/ {{ number_format($venta->total, 2) }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $venta->estadoVenta->estado ?? 'Sin estado' }}
                        </span>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">No hay ventas pendientes por entregar.</div>
    @endif
</div>
@endsection