@if($pedidos && $pedidos->count() > 0)
    @foreach($pedidos as $pedido)
        <div class="pedido-card mb-4 p-3 border rounded">
            <h5 class="fw-bold">Pedido #{{ $pedido->id }}</h5>
            <p>Fecha: {{ $pedido->fecha ? $pedido->fecha->format('d/m/Y H:i') : '-' }}</p>
            <p>Estado: {{ $pedido->estadoVenta->nombre ?? 'Sin estado' }}</p>
            <p>Total: S/. {{ number_format($pedido->total, 2) }}</p>

            <ul>
                @foreach($pedido->detalleVentas as $detalle)
                    <li>
                        {{ $detalle->producto->nombre ?? 'Producto eliminado' }}
                        (x{{ $detalle->cantidad }}) - 
                        S/. {{ number_format($detalle->precio_venta, 2) }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-box" style="font-size: 2rem;"></i>
        <p class="mt-3">No tienes pedidos registrados</p>
    </div>
@endif
