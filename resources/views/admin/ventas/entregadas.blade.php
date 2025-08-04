@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Ventas Entregadas</h2>

    <a href="{{ route('admin.ventas.pendientes') }}" class="btn btn-secondary mb-3">Volver a ventas pendientes</a>

    @if ($ventas->count() > 0)
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total (S/)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ number_format($venta->total, 2) }}</td>
                <td><span class="badge bg-success">Entregada</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">No hay ventas entregadas aún.</div>
    @endif
</div>
@endsection
