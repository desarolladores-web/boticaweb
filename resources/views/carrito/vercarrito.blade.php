@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-4">Mi carrito ({{ count(session('carrito', [])) }})</h5>

    <div class="row">
        <!-- LISTADO DE PRODUCTOS -->
        <div class="col-lg-8">
            <div class="card p-4">

                {{-- Cabecera de columnas --}}
                <div class="row fw-semibold text-muted border-bottom pb-2 mb-3 text-center" style="font-size: 14px;">
                    <div class="col-md-3 text-start">PRODUCTOS</div>
                    <div class="col-md-2">PRESENTACIÓN</div>
                    <div class="col-md-2">CANTIDAD</div>
                    <div class="col-md-2">PRECIO UNIDAD</div>
                    <div class="col-md-2">SUBTOTAL</div>
                    <div class="col-md-1"></div>
                </div>

                @php
                $carrito = session('carrito', []);
                $total = 0;
                @endphp

                @forelse($carrito as $id => $item)
                @php
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
                @endphp

                <div class="row align-items-center mb-4 pb-3 border-bottom text-center">
                    <!-- Producto -->
                    <div class="col-md-3 d-flex align-items-center text-start">
                        @if($item['imagen'])
                        <img src="{{ $item['imagen'] }}" alt="Imagen" class="me-3 rounded" width="60" height="60">
                        @endif
                        <div>
                            <strong>{{ $item['nombre'] }}</strong>
                        </div>
                    </div>

                    <!-- Presentación -->
                    <div class="col-md-2 fw-semibold">
                        <div class="bg-light rounded px-3 py-1">{{ $item['presentacion'] ?? '—' }}</div>
                    </div>

                    <!-- Cantidad -->
                    <div class="col-md-2 fw-semibold">
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="actualizar-cantidad-form me-1" data-id="{{ $id }}">
                                @csrf
                                <input type="hidden" name="tipo" value="restar">
                                <button class="btn btn-outline-secondary btn-sm" type="submit">−</button>
                            </form>

                            <span class="px-2 cantidad-texto" data-id="{{ $id }}">{{ $item['cantidad'] }}</span>

                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="actualizar-cantidad-form ms-1" data-id="{{ $id }}">
                                @csrf
                                <input type="hidden" name="tipo" value="sumar">
                                <button class="btn btn-outline-secondary btn-sm" type="submit">+</button>
                            </form>
                        </div>
                    </div>

                    <!-- Precio Unidad -->
                    <div class="col-md-2 fw-semibold">
                        <div>S/ {{ number_format($item['precio'], 2) }}</div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-2 fw-semibold subtotal-producto" data-id="{{ $id }}">
                        <span class="subtotal-valor">S/ {{ number_format($subtotal, 2) }}</span>
                    </div>

                    <!-- Eliminar -->
                    <div class="col-md-1">
                        <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="form-eliminar" data-id="{{ $id }}">
                            @csrf
                            <input type="hidden" name="redirect_back" value="{{ route('carrito.ver') }}">
                            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0">Eliminar</button>
                        </form>
                    </div>
                </div>

                @empty
                <p class="text-muted">Tu carrito está vacío.</p>
                @endforelse

            </div>
        </div>

        <!-- RESUMEN DE COMPRA -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card p-4">
                <h6 class="fw-bold mb-3">Resumen de compra</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal-general">S/ {{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total a pagar</span>
                    <strong id="total-general" class="text-success">S/ {{ number_format($total, 2) }}</strong>
                </div>

                <button type="button" class="btn btn-danger rounded-pill mt-3 w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    Comprar ahora
                </button>

                <!-- MODAL: ¿Iniciar sesión o continuar como invitado? -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="checkoutModalLabel">¿Cómo deseas continuar?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Para finalizar tu compra, puedes iniciar sesión o continuar sin cuenta.</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-person-circle me-2"></i> Iniciar sesión / Registrarse
                                    </a>
                                    <a href="{{ route('checkout.formulario') }}" class="btn btn-primary">
                                        <i class="bi bi-box-arrow-right me-2"></i> Continuar sin cuenta
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Actualizar cantidad
    const formsActualizar = document.querySelectorAll('.actualizar-cantidad-form');
    formsActualizar.forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const url = form.action;
            const formData = new FormData(form);
            const id = form.dataset.id;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    // Actualiza cantidad visible
                    const cantidadSpan = document.querySelector(`.cantidad-texto[data-id="${id}"]`);
                    if (cantidadSpan) cantidadSpan.textContent = data.cantidad;

                    // Actualiza subtotal producto
                    const subtotalValorElem = document.querySelector(`.subtotal-producto[data-id="${id}"] .subtotal-valor`);
                    if (subtotalValorElem) subtotalValorElem.textContent = `S/ ${parseFloat(data.subtotal).toFixed(2)}`;

                    // Actualiza subtotal y total general
                    const subtotalGeneral = document.getElementById('subtotal-general');
                    const totalGeneral = document.getElementById('total-general');
                    if (subtotalGeneral) subtotalGeneral.textContent = `S/ ${parseFloat(data.total).toFixed(2)}`;
                    if (totalGeneral) totalGeneral.textContent = `S/ ${parseFloat(data.total).toFixed(2)}`;
                } else {
                    alert('Error al actualizar el carrito');
                }
            } catch (error) {
                alert('Error de comunicación con el servidor');
                console.error(error);
            }
        });
    });

    // Eliminar producto sin recargar
    const formsEliminar = document.querySelectorAll('.form-eliminar');
    formsEliminar.forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();

            const url = form.action;
            const formData = new FormData(form);
            const id = form.dataset.id;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    // Eliminar visualmente el producto del DOM
                    const productoElem = form.closest('.row.align-items-center');
                    if (productoElem) productoElem.remove();

                    // Actualiza subtotal y total general
                    const subtotalGeneral = document.getElementById('subtotal-general');
                    const totalGeneral = document.getElementById('total-general');
                    if (subtotalGeneral && data.total !== undefined) subtotalGeneral.textContent = `S/ ${parseFloat(data.total).toFixed(2)}`;
                    if (totalGeneral && data.total !== undefined) totalGeneral.textContent = `S/ ${parseFloat(data.total).toFixed(2)}`;
                } else {
                    alert('No se pudo eliminar el producto');
                }
            } catch (error) {
                alert('Error en la comunicación con el servidor');
                console.error(error);
            }
        });
    });
});
</script>
