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
document.addEventListener('submit', function (e) {
    if (e.target.matches('.form-actualizar-cantidad, .eliminar-item-form')) {
        e.preventDefault();

        const form = e.target;
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
            // Actualizar contador
            const contador = document.getElementById('contador-carrito');
            if (contador && data.cantidadTotal !== undefined) {
                contador.textContent = data.cantidadTotal;
            }

            // Actualizar cantidad en sidebar
            if (data.producto_id && data.cantidad !== undefined) {
                const cantidadElem = document.getElementById('cantidad-' + data.producto_id);
                if (cantidadElem) {
                    cantidadElem.textContent = data.cantidad;
                }
            }

            // Si eliminamos producto
            if (data.eliminado && data.producto_id) {
                // Quitar del sidebar
                const itemElem = document.getElementById('item-' + data.producto_id);
                if (itemElem) {
                    itemElem.remove();
                }

                // Cambiar en welcome al botón "Agregar carrito"
                const containerWelcome = document.getElementById('carrito-container-' + data.producto_id);
                if (containerWelcome) {
                    containerWelcome.innerHTML = `
                        <form method="POST" action="/carrito/agregar/${data.producto_id}" class="agregar-carrito-form">
                            <input type="hidden" name="_token" value="${formData.get('_token')}">
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="button">
                                Agregar Carrito
                                <span class="iconify ms-2" data-icon="uil:shopping-cart" style="font-size: 24px;"></span>
                            </button>
                        </form>
                    `;
                }
            }

            // Si el carrito queda vacío
            if (data.vacio) {
                const contenedor = document.getElementById('cart-items');
                if (contenedor) {
                    contenedor.innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
                }
            }
        })
        .catch(error => console.error('Error en acción del carrito:', error));
    }
});
</script>






