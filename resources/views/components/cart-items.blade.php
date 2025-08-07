@php $carrito = session('carrito', []); @endphp

@if(count($carrito) > 0)
    @foreach($carrito as $id => $item)
        <div class="mb-3 border-bottom pb-3 producto-item">
            <div class="d-flex align-items-center">
                @if($item['imagen'])
                    <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="me-3 cart-img"
                        style="width: 60px;">
                @endif

                <div class="flex-grow-1 ps-2">
                    <div class="fw-bold">{{ $item['nombre'] }}</div>
                    @php $subtotal = $item['precio'] * $item['cantidad']; @endphp
                    <div class="text-danger fw-semibold mb-2">S/ {{ number_format($subtotal, 2) }}</div>

                    <div class="d-flex align-items-center mb-2" style="width: fit-content;">
                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center me-1">
                            @csrf
                            <input type="hidden" name="tipo" value="restar">
                            <input type="hidden" name="desde_sidebar" value="1">
                            <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">−</button>
                        </form>

                        <div class="px-3">{{ $item['cantidad'] }}</div>

                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center ms-1">
                            @csrf
                            <input type="hidden" name="tipo" value="sumar">
                            <input type="hidden" name="desde_sidebar" value="1">
                            <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">+</button>
                        </form>
                    </div>

                    {{-- ✅ Formulario eliminar con clase para JS --}}
                    <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="form-eliminar-sidebar eliminar-item-form">
                        @csrf
                        <input type="hidden" name="desde_sidebar" value="1">
                        <input type="hidden" name="redirect_back" value="{{ url()->current() }}">
                        <button type="submit" class="btn btn-danger rounded-pill btn-sm mt-1">Eliminar Producto</button>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="text-muted">Tu carrito está vacío.</p>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const contenedor = document.getElementById('cart-items');

    if (contenedor) {
        contenedor.addEventListener('submit', function (e) {
            const form = e.target;

            // Verificamos si es un formulario de eliminar, sumar o restar
            if (
                form.classList.contains('eliminar-item-form') ||
                (form.querySelector('input[name="tipo"]') && 
                 ['sumar', 'restar'].includes(form.querySelector('input[name="tipo"]').value))
            ) {
                e.preventDefault();

                const url = form.action;
                const formData = new FormData(form);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    // ✅ Actualizar contador del carrito
                    const contador = document.getElementById('contador-carrito');
                    if (contador && data.cantidadTotal !== undefined) {
                        contador.textContent = data.cantidadTotal;
                    }

                    // ✅ Actualizar el contenido del sidebar
                    if (typeof actualizarSidebarCarrito === 'function') {
                        actualizarSidebarCarrito();
                    }

                    // ✅ Actualizar cantidad en pantalla sin recargar
                    if (data.item_id && data.nuevaCantidad !== undefined) {
                        const cantidadElemento = document.querySelector(`#cantidad-${data.item_id}`);
                        if (cantidadElemento) {
                            cantidadElemento.textContent = data.nuevaCantidad;
                        }
                    }
                })
                .catch(error => console.error('Error en acción del carrito:', error));
            }
        });
    }
});
</script>

