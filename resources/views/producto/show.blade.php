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
                            <a class="btn btn-primary btn-sm" href="{{ route('productos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo:</strong>
                                    {{ $producto->codigo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $producto->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Descripcion:</strong>
                                    {{ $producto->descripcion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Principio Activo:</strong>
                                    {{ $producto->principio_activo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Pvp1:</strong>
                                    {{ $producto->pvp1 }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Precio Costo Unitario:</strong>
                                    {{ $producto->precio_costo_unitario }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Stock:</strong>
                                    {{ $producto->stock }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Stock Min:</strong>
                                    {{ $producto->stock_min }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Vencimiento:</strong>
                                    {{ $producto->fecha_vencimiento }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Imagen:</strong>
                                    {{ $producto->imagen }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Categoria Id:</strong>
                                    {{ $producto->categoria_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Laboratorio Id:</strong>
                                    {{ $producto->laboratorio_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Presentacion Id:</strong>
                                    {{ $producto->presentacion_id }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
