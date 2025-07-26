@extends('layouts.admin')

@section('template_title')
    {{ $producto->name ?? __('Show') . " " . __('Producto') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('productos.index') }}"> {{ __('Atras') }}</a>
                        </div>
                    </div>

             <div class="card-body bg-white">
    <div class="row">
        <!-- Imagen a la izquierda -->
        <div class="col-md-4 text-center">
            @if ($producto->imagen)
                <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-thumbnail w-100" alt="Producto">
            @else
                <span class="text-muted">Sin imagen</span>
            @endif
        </div>

        <!-- Información del producto a la derecha -->
        <div class="col-md-8">
            <div class="form-group mb-2">
                <strong>Código:</strong> {{ $producto->codigo }}
            </div>
            <div class="form-group mb-2">
                <strong>Nombre:</strong> {{ $producto->nombre }}
            </div>
            <div class="form-group mb-2">
                <strong>Descripción:</strong> {{ $producto->descripcion }}
            </div>
            <div class="form-group mb-2">
                <strong>Principio Activo:</strong> {{ $producto->principio_activo }}
            </div>
            <div class="form-group mb-2">
                <strong>Pvp1:</strong> {{ $producto->pvp1 }}
            </div>
            <div class="form-group mb-2">
                <strong>Precio Costo Unitario:</strong> {{ $producto->precio_costo_unitario }}
            </div>
            <div class="form-group mb-2">
                <strong>Stock:</strong> {{ $producto->stock }}
            </div>
            <div class="form-group mb-2">
                <strong>Stock Min:</strong> {{ $producto->stock_min }}
            </div>
            <div class="form-group mb-2">
                <strong>Fecha Vencimiento:</strong> {{ $producto->fecha_vencimiento }}
            </div>
            <div class="form-group mb-2">
                <strong>Categoría ID:</strong> {{ $producto->categoria_id }}
            </div>
            <div class="form-group mb-2">
                <strong>Laboratorio ID:</strong> {{ $producto->laboratorio_id }}
            </div>
            <div class="form-group mb-2">
                <strong>Presentación ID:</strong> {{ $producto->presentacion_id }}
            </div>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
