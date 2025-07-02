@extends('layouts.app')

@section('template_title')
    {{ $venta->name ?? __('Show') . " " . __('Venta') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Venta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ventas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Cliente Id:</strong>
                                    {{ $venta->cliente_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha:</strong>
                                    {{ $venta->fecha }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo Comprobante:</strong>
                                    {{ $venta->tipo_comprobante }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Igv:</strong>
                                    {{ $venta->igv }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Subtotal:</strong>
                                    {{ $venta->subtotal }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total:</strong>
                                    {{ $venta->total }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Metodo Pago Id:</strong>
                                    {{ $venta->metodo_pago_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado Venta Id:</strong>
                                    {{ $venta->estado_venta_id }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
