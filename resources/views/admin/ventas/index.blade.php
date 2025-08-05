@extends('layouts.admin')

@section('content')

<div class="container ">
    <h2 class="mb-4">Ventas pendientes para entrega</h2>

    <a href="{{ route('admin.ventas.entregadas') }}" class="btn btn-outline-primary mb-4">
        <i class="bi bi-truck"></i> Ver ventas entregadas
    </a>

    @if ($ventas->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>

                    <th>Tipo de documento</th>
                    <th>N° de documento</th>
                    <th>Total (S/)</th>
                    <th>Fecha</th>

                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr class="table-primary">
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
                    <td>{{ $venta->cliente->tipoDocumento->nombre_documento ?? 'Sin documento' }}</td>
                    <td> {{ $venta->cliente->DNI }}</td>
                    <td>S/ {{ number_format($venta->total, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>


                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $venta->estadoVenta->estado ?? 'Sin estado' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.ventas.marcarEntregada', $venta->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Marcar como entregada?')">
                                <i class="bi bi-check-circle"></i> Marcar como entregada
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Productos de la venta -->
                <tr>
                    <td colspan="6">
                        <strong>Productos:</strong>
                        <ul class="mb-0">
                            @foreach ($venta->detalleVentas as $detalle)
                            <li>
                                {{ $detalle->producto->nombre }} - Cantidad: {{ $detalle->cantidad }}
                            </li>
                            @endforeach
                        </ul>
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