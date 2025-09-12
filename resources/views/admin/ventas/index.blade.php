@extends('layouts.admin')

@section('content')

    <div class="container">


        {{-- Título --}}
        <h4 class="mb-4">
            <span style="font-size: 1.5rem; margin-right: 10px;">📦</span>
            <strong>Listado de Ventas Pendientes</strong>
        </h4>

        {{-- Encabezado tipo productos (imagen 1 adaptada) --}}
        <div class="card mb-4">
            <div class="card-body d-flex flex-wrap align-items-center gap-2">
                <select class="form-select" style="max-width: 250px;">
                    <option selected>Seleccione una opción</option>
                    <option value="1">Por cliente</option>
                    <option value="2">Por documento</option>
                    <option value="3">Por fecha</option>
                </select>

                <input type="text" class="form-control" placeholder="Buscar" style="max-width: 250px;">

                <button class="btn btn-danger">
                    <i class="bi bi-search"></i>
                </button>

                <button type="submit">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>

                <form action="{{ route('admin.ventas.entregadas') }}" method="GET" class="ms-auto">
                    <button type="submit" <i class="bi bi-truck"></i> Ver ventas entregadas
                    </button>
                </form>

            </div>
        </div>



        {{-- Lista de ventas --}}
        @if ($ventas->count() > 0)
            @foreach ($ventas as $venta)
                <div class="card mb-4 shadow-sm border border-warning">
                    <div class="card-header bg-warning-subtle d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Venta #{{ $venta->id }}</strong> |
                            Cliente: {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }} |
                            Documento: {{ $venta->cliente->tipoDocumento->nombre_documento ?? 'Sin documento' }} -
                            {{ $venta->cliente->DNI }}
                        </div>
                        <div>
                            <form id="form-entregar-{{ $venta->id }}"
                                action="{{ route('admin.ventas.marcarEntregada', $venta->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn btn-success btn-sm btn-confirmar-entrega">
                                    <i class="bi bi-check-circle"></i> Marcar como entregada
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body bg-light">
                        <p class="mb-1"><strong>Total:</strong> S/ {{ number_format($venta->total, 2) }}</p>
                        <p class="mb-1"><strong>Fecha:</strong>
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</p>
                        <p class="mb-3">
                            <strong>Estado:</strong>
                            <span class="badge bg-warning text-dark">
                                {{ $venta->estadoVenta->estado ?? 'Sin estado' }}
                            </span>
                        </p>

                        <div class="bg-white p-3 rounded border">
                            <strong>Productos:</strong>
                            <ul class="mb-0">
                                @foreach ($venta->detalleVentas as $detalle)
                                    <li>{{ $detalle->producto->nombre ?? 'Producto eliminado' }} - Cantidad:
                                        {{ $detalle->cantidad }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">No hay ventas pendientes por entregar.</div>
        @endif

        {{-- Paginación (imagen 2) --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $ventas->links('pagination::bootstrap-5') }}
        </div>

    </div>

    {{-- Script de confirmación --}}
    <script>
        document.querySelectorAll('.btn-confirmar-entrega').forEach(boton => {
            boton.addEventListener('mouseover', function() {
                this.classList.add('btn-hover-green');
            });

            boton.addEventListener('mouseout', function() {
                this.classList.remove('btn-hover-green');
            });

            boton.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Deseas marcar esta venta como entregada?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#218838',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, marcar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    {{-- Estilos adicionales --}}
    <style>
        .btn-confirmar-entrega {
            background-color: #28a745 !important;
            /* Verde */
            border-color: #28a745 !important;
            color: white !important;
        }

        .btn-confirmar-entrega:hover {
            background-color: #218838 !important;
            /* Verde más oscuro */
            border-color: #1e7e34 !important;
        }
    </style>

@endsection
