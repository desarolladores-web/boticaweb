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
                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="me-1">
                                @csrf
                                <input type="hidden" name="tipo" value="restar">
                                <button class="btn btn-outline-secondary btn-sm">−</button>
                            </form>
                            <span class="px-2">{{ $item['cantidad'] }}</span>
                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="ms-1">
                                @csrf
                                <input type="hidden" name="tipo" value="sumar">
                                <button class="btn btn-outline-secondary btn-sm">+</button>
                            </form>
                        </div>
                    </div>

                    <!-- Precio Unidad -->
                    <div class="col-md-2 fw-semibold">
                        <div>S/ {{ number_format($item['precio'], 2) }}</div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-2 fw-semibold">
                        S/ {{ number_format($subtotal, 2) }}
                    </div>

                    <!-- Eliminar -->
                    <div class="col-md-1 ">
                        <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                            @csrf
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
                    <span>S/ {{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total a pagar</span>
                    <strong class="text-success">S/ {{ number_format($total, 2) }}</strong>
                </div>

                <a href="{{ route('ventas.create', ['total' => $total]) }}" class="btn btn-danger rounded-pill w-100 mt-3">Comprar ahora</a>
            </div>
        </div>
    </div>
</div>
@endsection