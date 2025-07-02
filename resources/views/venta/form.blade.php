<style>
.checkout {
	padding-top: 80px;
	padding-bottom: 70px;
}


.checkout__form h5 {
	color: #111111;
	font-weight: 600;
	text-transform: uppercase;
	border-bottom: 1px solid #e1e1e1;
	padding-bottom: 20px;
	margin-bottom: 25px;
}

.checkout__form .checkout__form__input p {
	color: #444444;
	font-weight: 500;
	margin-bottom: 10px;
}

.checkout__form .checkout__form__input p span {
	color: #ca1515;
}

.checkout__form .checkout__form__input input {
	height: 50px;
	width: 100%;
	border: 1px solid #e1e1e1;
	border-radius: 2px;
	margin-bottom: 25px;
	font-size: 14px;
	padding-left: 20px;
	color: #666666;
}

.checkout__form .checkout__form__input input::-webkit-input-placeholder {
	color: #666666;
}

.checkout__form .checkout__form__input input::-moz-placeholder {
	color: #666666;
}

.checkout__form .checkout__form__input input:-ms-input-placeholder {
	color: #666666;
}

.checkout__form .checkout__form__input input::-ms-input-placeholder {
	color: #666666;
}

.checkout__form .checkout__form__input input::placeholder {
	color: #666666;
}

.checkout__form .checkout__form__checkbox {
	margin-bottom: 20px;
}

.checkout__form .checkout__form__checkbox label {
	display: block;
	padding-left: 24px;
	font-size: 14px;
	color: #444444;
	font-weight: 500;
	position: relative;
	cursor: pointer;
	margin-bottom: 16px;
}

.checkout__form .checkout__form__checkbox label input {
	position: absolute;
	visibility: hidden;
}

.checkout__form .checkout__form__checkbox label input:checked~.checkmark {
	border-color: #ca1515;
}

.checkout__form .checkout__form__checkbox label input:checked~.checkmark:after {
	border-color: #ca1515;
	opacity: 1;
}

.checkout__form .checkout__form__checkbox label .checkmark {
	position: absolute;
	left: 0;
	top: 4px;
	height: 10px;
	width: 10px;
	border: 1px solid #444444;
	border-radius: 2px;
}

.checkout__form .checkout__form__checkbox label .checkmark:after {
	position: absolute;
	left: 0px;
	top: -2px;
	width: 11px;
	height: 5px;
	border: solid #ffffff;
	border-width: 1.5px 1.5px 0px 0px;
	-webkit-transform: rotate(127deg);
	-ms-transform: rotate(127deg);
	transform: rotate(127deg);
	opacity: 0;
	content: "";
}

.checkout__form .checkout__form__checkbox p {
	margin-bottom: 0;
}

.checkout__order {
	background: #f5f5f5;
	padding: 30px;
}

.checkout__order h5 {
	border-bottom: 1px solid #d7d7d7;
	margin-bottom: 18px;
}

.checkout__order .site-btn {
	width: 100%;
}

.checkout__order__product {
	border-bottom: 1px solid #d7d7d7;
	padding-bottom: 22px;
}

.checkout__order__product ul li {
	list-style: none;
	font-size: 14px;
	color: #444444;
	font-weight: 500;
	overflow: hidden;
	margin-bottom: 14px;
	line-height: 24px;
}

.checkout__order__product ul li:last-child {
	margin-bottom: 0;
}

.checkout__order__product ul li span {
	font-size: 14px;
	color: #111111;
	font-weight: 600;
	float: right;
}

.checkout__order__product ul li .top__text {
	font-size: 16px;
	color: #111111;
	font-weight: 600;
	float: left;
}

.checkout__order__product ul li .top__text__right {
	font-size: 16px;
	color: #111111;
	font-weight: 600;
	float: right;
}

.checkout__order__total {
	padding-top: 12px;
	border-bottom: 1px solid #d7d7d7;
	padding-bottom: 10px;
	margin-bottom: 25px;
}

.checkout__order__total ul li {
	list-style: none;
	font-size: 16px;
	color: #111111;
	font-weight: 600;
	overflow: hidden;
	line-height: 40px;
}

.checkout__order__total ul li span {
	color: #ca1515;
	float: right;
}

.checkout__order__widget {
	padding-bottom: 10px;
}

.checkout__order__widget label {
	display: block;
	padding-left: 25px;
	font-size: 14px;
	font-weight: 500;
	color: #111111;
	position: relative;
	cursor: pointer;
	margin-bottom: 14px;
}

.checkout__order__widget label input {
	position: absolute;
	visibility: hidden;
}

.checkout__order__widget label input:checked~.checkmark {
	border-color: #ca1515;
}

.checkout__order__widget label input:checked~.checkmark:after {
	border-color: #ca1515;
	opacity: 1;
}

.checkout__order__widget label .checkmark {
	position: absolute;
	left: 0;
	top: 4px;
	height: 10px;
	width: 10px;
	border: 1px solid #444444;
	border-radius: 2px;
}

.checkout__order__widget label .checkmark:after {
	position: absolute;
	left: 0px;
	top: -2px;
	width: 11px;
	height: 5px;
	border: solid #ffffff;
	border-width: 1.5px 1.5px 0px 0px;
	-webkit-transform: rotate(127deg);
	-ms-transform: rotate(127deg);
	transform: rotate(127deg);
	opacity: 0;
	content: "";
}
   
</style>


<section class="checkout spad">
    <div class="container">

        <form action="#" class="checkout__form">
            <div class="row">
                <div class="col-lg-8">
                    <h5>Detalle de facturación</h5>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Nombre <span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Apellido <span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>País <span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__form__input">
                                <p>Dirección <span>*</span></p>
                                <input type="text" placeholder="Dirección de la calle">
                                <input type="text" placeholder="Apartamento, suite, unidad, etc (opcional)">
                            </div>
                            <div class="checkout__form__input">
                                <p>Ciudad <span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__form__input">
                                <p>Provincia/Estado <span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__form__input">
                                <p>Código postal <span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Teléfono <span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__checkbox">
                                <label for="acc">
                                    ¿Crear una cuenta?
                                    <input type="checkbox" id="acc">
                                    <span class="checkmark"></span>
                                </label>
                                <p>Crea una cuenta ingresando la información a continuación. Si ya eres cliente, inicia sesión en la parte superior de la página.</p>
                            </div>
                            <div class="checkout__form__input">
                                <p>Contraseña de la cuenta <span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__form__checkbox">
                                <label for="note">
                                    Nota sobre tu pedido, por ejemplo, instrucciones especiales de entrega
                                    <input type="checkbox" id="note">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__form__input">
                                <p>Notas del pedido <span>*</span></p>
                                <input type="text" placeholder="Nota sobre tu pedido, por ejemplo, instrucciones especiales de entrega">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="checkout__order">
                        <h5>Tu pedido</h5>
                        <div class="checkout__order__product">
                            <ul>
                                <li>
                                    <span class="top__text">Producto</span>
                                    <span class="top__text__right">Total</span>
                                </li>
                                <li>01. Bolso con cadena <span>$ 300.0</span></li>
                                <li>02. Maletín con bolsillos con cierre <span>$ 170.0</span></li>
                                <li>03. Jean negro <span>$ 170.0</span></li>
                                <li>04. Camisa de algodón <span>$ 110.0</span></li>
                            </ul>
                        </div>
                        <div class="checkout__order__total">
                            <ul>
                                <li>Subtotal <span>$ 750.0</span></li>
                                <li>Total <span>$ 750.0</span></li>
                            </ul>
                        </div>
                        <div class="checkout__order__widget">
                            <label for="o-acc">
                                ¿Crear una cuenta?
                                <input type="checkbox" id="o-acc">
                                <span class="checkmark"></span>
                            </label>
                            <p>Crea una cuenta ingresando la información a continuación. Si ya eres cliente, inicia sesión en la parte superior de la página.</p>
                            <label for="check-payment">
                                Pago con cheque
                                <input type="checkbox" id="check-payment">
                                <span class="checkmark"></span>
                            </label>
                            <label for="paypal">
                                PayPal
                                <input type="checkbox" id="paypal">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn">Realizar pedido</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

       


<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="cliente_id" class="form-label">{{ __('Cliente Id') }}</label>
            <input type="text" name="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" value="{{ old('cliente_id', $venta?->cliente_id) }}" id="cliente_id" placeholder="Cliente Id">
            {!! $errors->first('cliente_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
            <input type="text" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $venta?->fecha) }}" id="fecha" placeholder="Fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo_comprobante" class="form-label">{{ __('Tipo Comprobante') }}</label>
            <input type="text" name="tipo_comprobante" class="form-control @error('tipo_comprobante') is-invalid @enderror" value="{{ old('tipo_comprobante', $venta?->tipo_comprobante) }}" id="tipo_comprobante" placeholder="Tipo Comprobante">
            {!! $errors->first('tipo_comprobante', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="igv" class="form-label">{{ __('Igv') }}</label>
            <input type="text" name="igv" class="form-control @error('igv') is-invalid @enderror" value="{{ old('igv', $venta?->igv) }}" id="igv" placeholder="Igv">
            {!! $errors->first('igv', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="subtotal" class="form-label">{{ __('Subtotal') }}</label>
            <input type="text" name="subtotal" class="form-control @error('subtotal') is-invalid @enderror" value="{{ old('subtotal', $venta?->subtotal) }}" id="subtotal" placeholder="Subtotal">
            {!! $errors->first('subtotal', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="total" class="form-label">{{ __('Total') }}</label>
            <input type="text" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ old('total', $venta?->total) }}" id="total" placeholder="Total">
            {!! $errors->first('total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="metodo_pago_id" class="form-label">{{ __('Metodo Pago Id') }}</label>
            <input type="text" name="metodo_pago_id" class="form-control @error('metodo_pago_id') is-invalid @enderror" value="{{ old('metodo_pago_id', $venta?->metodo_pago_id) }}" id="metodo_pago_id" placeholder="Metodo Pago Id">
            {!! $errors->first('metodo_pago_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado_venta_id" class="form-label">{{ __('Estado Venta Id') }}</label>
            <input type="text" name="estado_venta_id" class="form-control @error('estado_venta_id') is-invalid @enderror" value="{{ old('estado_venta_id', $venta?->estado_venta_id) }}" id="estado_venta_id" placeholder="Estado Venta Id">
            {!! $errors->first('estado_venta_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>