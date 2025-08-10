@php $carrito = session('carrito', []); @endphp

@if(count($carrito) > 0)
    @foreach($carrito as $id => $item)
        <div class="mb-3 border-bottom pb-3 producto-item" id="item-{{ $id }}">
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
                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center me-1 form-actualizar-cantidad">
                            @csrf
                            <input type="hidden" name="tipo" value="restar">
                            <input type="hidden" name="desde_sidebar" value="1">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">−</button>
                        </form>

                        <div class="px-3 cantidad-numero" id="cantidad-{{ $id }}">{{ $item['cantidad'] }}</div>

                        <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex align-items-center ms-1 form-actualizar-cantidad">
                            @csrf
                            <input type="hidden" name="tipo" value="sumar">
                            <input type="hidden" name="desde_sidebar" value="1">
                            <button type="submit" class="btn btn-outline-secondary btn-sm px-2">+</button>
                        </form>
                    </div>

                    {{-- ✅ Formulario eliminar con clase para JS --}}
                    <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="form-eliminar-sidebar eliminar-item-form">
                        @csrf
                        <input type="hidden" name="desde_sidebar" value="1">
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

            // Verificar si es un formulario de eliminar o actualizar cantidad
            if (
                form.classList.contains('eliminar-item-form') ||
                form.classList.contains('form-actualizar-cantidad')
            ) {
                // 🚫 Siempre evitar recargar la página
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

                    // ✅ Actualizar cantidad del producto
                    if (data.producto_id && data.cantidad !== undefined) {
                        const cantidadElem = document.getElementById('cantidad-' + data.producto_id);
                        if (cantidadElem) {
                            cantidadElem.textContent = data.cantidad;
                        }
                    }

                    // ✅ Si eliminar: quitar el producto del DOM
                    if (data.eliminado && data.producto_id) {
                        const itemElem = document.getElementById('item-' + data.producto_id);
                        if (itemElem) {
                            itemElem.remove();
                        }
                    }

                    // ✅ Si el carrito quedó vacío, mostrar mensaje
                    if (data.vacio) {
                        contenedor.innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
                    }

                    // ✅ Refrescar contenido del sidebar si existe función
                    if (typeof actualizarSidebarCarrito === 'function') {
                        actualizarSidebarCarrito();
                    }
                })
                .catch(error => console.error('Error en acción del carrito:', error));
            }
        });
    }
});
</script>


