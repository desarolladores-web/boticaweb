@extends('layouts.app')

@section('content')
<section class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-4">
    <div class="card shadow border border-primary rounded-3">
        <div class="card-header bg-primary text-white fw-bold text-center">
            <i class="bi bi-funnel-fill me-1"></i> Filtros
        </div>
        <div class="card-body">

            <!-- FILTRO POR CATEGORÍAS -->
            <h6 class="fw-bold mb-2 text-primary">Departamento</h6>
            <ul class="list-group list-unstyled mb-4 ps-1">
                <li>
                    <a href="{{ route('productos.filtro') }}"
                       class="text-decoration-none d-block py-1 {{ request('categoria') ? '' : 'fw-bold text-primary' }}">
                        Todas
                    </a>
                </li>
                @foreach ($categorias as $categoria)
                    <li>
                        <a href="{{ route('productos.filtro', array_merge(request()->except(['precio_min', 'precio_max']), ['categoria' => $categoria->id])) }}"
                           class="text-decoration-none d-block py-1 {{ request('categoria') == $categoria->id ? 'fw-bold text-primary' : '' }}">
                            {{ $categoria->nombre }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- FILTRO POR PRECIO -->
            <h6 class="fw-bold mb-2 text-primary">Precio</h6>
            <form method="GET" action="{{ route('productos.filtro') }}" id="filtro-precio-form">
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                <input type="hidden" name="precio_min" id="precio_min" value="{{ request('precio_min', 10) }}">
                <input type="hidden" name="precio_max" id="precio_max" value="{{ request('precio_max', 540) }}">

                <div class="range-slider mb-3">
                    <input type="range" id="slider_min" class="form-range" min="10" max="540" step="1"
                           value="{{ request('precio_min', 10) }}">
                    <input type="range" id="slider_max" class="form-range mt-1" min="10" max="540" step="1"
                           value="{{ request('precio_max', 540) }}">
                    <div class="text-center fw-bold text-danger small mt-1">
                        $<span id="label_min">{{ request('precio_min', 10) }}</span> - $<span id="label_max">{{ request('precio_max', 540) }}</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-funnel"></i> Aplicar filtros
                </button>
            </form>

        </div>
    </div>
</div>


        <!-- CARDS DE PRODUCTOS -->
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($productos as $producto)
                <div class="col">
                    <div class="card h-100 shadow border-0 rounded-4 product-card">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top product-img rounded-top-4" alt="{{ $producto->nombre }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" class="card-img-top product-img rounded-top-4" alt="Sin Imagen">
                        @endif
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-primary mb-2">{{ $producto->nombre }}</h6>
                            <p class="text-muted small mb-1">Stock: {{ $producto->stock }}</p>
                            <div class="price mb-3">S/. {{ number_format($producto->pvp1, 2) }}</div>
                            <a href="{{ route('productos.especificaciones', $producto->id) }}" class="btn btn-success btn-sm px-3 rounded-pill">Ver más</a>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">No se encontraron productos.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sliderMin = document.getElementById('slider_min');
    const sliderMax = document.getElementById('slider_max');
    const precioMinInput = document.getElementById('precio_min');
    const precioMaxInput = document.getElementById('precio_max');
    const label = document.getElementById('precio_range_label');

    function actualizarLabel() {
        let min = Math.min(parseInt(sliderMin.value), parseInt(sliderMax.value));
        let max = Math.max(parseInt(sliderMin.value), parseInt(sliderMax.value));

        precioMinInput.value = min;
        precioMaxInput.value = max;
        label.textContent = `S/. ${min} - S/. ${max}`;
    }

    sliderMin.addEventListener('input', actualizarLabel);
    sliderMax.addEventListener('input', actualizarLabel);

    // Inicializa al cargar
    actualizarLabel();
});
</script>
@endpush
<script>
    const sliderMin = document.getElementById('slider_min');
    const sliderMax = document.getElementById('slider_max');
    const labelMin = document.getElementById('label_min');
    const labelMax = document.getElementById('label_max');
    const precioMin = document.getElementById('precio_min');
    const precioMax = document.getElementById('precio_max');

    function updateLabels() {
        let min = parseInt(sliderMin.value);
        let max = parseInt(sliderMax.value);
        if (min > max) {
            [min, max] = [max, min]; // intercambia
        }
        labelMin.innerText = min;
        labelMax.innerText = max;
        precioMin.value = min;
        precioMax.value = max;
    }

    sliderMin.addEventListener('input', updateLabels);
    sliderMax.addEventListener('input', updateLabels);
    document.addEventListener('DOMContentLoaded', updateLabels);
</script>


@push('styles')

<style>
    .product-img {
        height: 200px;
        object-fit: cover;
    }

    .product-card {
        transition: all 0.2s ease-in-out;
        border: 1px solid #e0e0e0;
    }

    .product-card:hover {
        transform: scale(1.02);
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
    }

    .price {
        font-size: 1.1rem;
        font-weight: bold;
        color: #198754;
    }

    .list-group-item a {
        display: block;
        color: #000;
    }

    .list-group-item a:hover {
        color: #0d6efd;
    }

    .range-slider input[type="range"] {
    appearance: none;
    width: 100%;
    height: 4px;
    background: #ddd;
    border-radius: 2px;
    outline: none;
    margin: 0;
    padding: 0;
}

.range-slider input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #d10000;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.4);
}

.range-slider input[type="range"]::-moz-range-thumb {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #d10000;
    cursor: pointer;
    border: 2px solid #fff;
}

.range-slider input[type="range"]::-ms-thumb {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #d10000;
    cursor: pointer;
    border: 2px solid #fff;
}

</style>
@endpush
