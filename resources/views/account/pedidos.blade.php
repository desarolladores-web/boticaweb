@if($pedidos && $pedidos->count() > 0)
    <div class="row g-4">
        @foreach($pedidos as $pedido)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 border-0 rounded-4">
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar3 me-2"></i>
                            {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d M Y - H:i') : '-' }}
                        </p>

                        <h5 class="card-title fw-semibold mb-3 text-primary">
                            Total: S/. {{ number_format($pedido->total, 2) }}
                        </h5>

                        <h6 class="text-secondary mb-3">Detalle del pedido:</h6>
                        <ul class="list-group list-group-flush flex-grow-1 mb-3" style="max-height: 180px; overflow-y: auto;">
                            @foreach($pedido->detalleVentas as $detalle)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 pb-1">
                                    <span class="text-truncate" style="max-width: 70%">
                                        {{ $detalle->producto->nombre ?? 'Producto eliminado' }} (x{{ $detalle->cantidad }})
                                    </span>
                                    <span class="fw-bold text-success">S/. {{ number_format($detalle->precio_venta, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Opcional: si quieres botón para detalles o alguna acción --}}
                        {{-- <a href="{{ route('pedido.detalle', $pedido->id) }}" class="btn btn-outline-primary mt-auto">Ver Detalle</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-basket fs-1 mb-3"></i>
        <p class="fs-5">No tienes pedidos registrados</p>
    </div>
@endif
