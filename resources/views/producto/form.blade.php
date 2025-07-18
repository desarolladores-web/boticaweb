
<style>
    .styled-input {
  border: 1.9px solid #d4d4d4;
  transition: border-color 1.1s ease, box-shadow 0.3s ease;
  border-radius: 0.6rem;

}

.styled-input:focus {
  border-color: #ff0000;/* Anula el azul */
  box-shadow: 0 0 0 0.2rem rgba(236, 28, 28, 0.486) !important;
  outline: none;
}

/* Animación suave para el label */
.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
  opacity: 1;
  transform: scale(0.85) translateY(-2.0rem) translateX(0.15rem);
  color: #ff0000;
  font-weight: 550;
}

.form-floating > label {
  transition: all 0.2s ease-in-out;
  color:  #9b9a9a;
  font-weight: 450;
}
.custom-shadow {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15) !important;
}
.d-flex  button {
  background-color: #ff0000; /* Color de fondo del botón */
  color: #fff; /* Color del texto */
  border: none;
  padding: 12px 20px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.d-flex  button:hover {
  background-color: #ee4c4c;
  color: #fff; /* Color al pasar el mouse */
}
</style>


<div class="container-fluid">

    <div class="row">
        <!-- Columna izquierda -->
        <div class="col-md-6">
            <div class="card mb-1 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Información del producto</h5>
                    <small class="text-muted">Pedidos realizados en su tienda</small>
                </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre" class="form-control styled-input @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto?->nombre) }}" placeholder="Nombre">
                        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="nombre">Nombre</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-floating mb-3">
                            <input type="text" name="codigo" class="form-control styled-input @error('codigo') is-invalid @enderror" value="{{ old('codigo', $producto?->codigo) }}" placeholder="Código">
                            {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
                            <label for="codigo">Código</label>
                        </div>
                        <div class="col-md-6 form-floating mb-3">
                            <input type="text" name="principio_activo" class="form-control styled-input @error('principio_activo') is-invalid @enderror" value="{{ old('principio_activo', $producto?->principio_activo) }}" placeholder="Principio Activo">
                            {!! $errors->first('principio_activo', '<div class="invalid-feedback">:message</div>') !!}
                            <label for="principio_activo">Principio Activo</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción (opcional)</label>
                        <div id="editor" style="height: 120px; background: #fff; border: 2px solid #ced4da; border-radius: 0.375rem; padding: 10px;">
                            {!! old('descripcion', $producto?->descripcion) !!}
                        </div>
                        <input type="hidden" name="descripcion" id="descripcion">
                        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="col-md-6">
            <div class="card mb-1 shadow-sm">
            <div class="card-header">
            </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="pvp1" class="form-control styled-input @error('pvp1') is-invalid @enderror" value="{{ old('pvp1', $producto?->pvp1) }}" placeholder="PVP1">
                        {!! $errors->first('pvp1', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="pvp1">PVP1</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="precio_costo_unitario" class="form-control styled-input @error('precio_costo_unitario') is-invalid @enderror" value="{{ old('precio_costo_unitario', $producto?->precio_costo_unitario) }}" placeholder="Precio Costo Unitario">
                        {!! $errors->first('precio_costo_unitario', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="precio_costo_unitario">Precio Costo Unitario</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="stock" class="form-control styled-input @error('stock') is-invalid @enderror" value="{{ old('stock', $producto?->stock) }}" placeholder="Stock">
                        {!! $errors->first('stock', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="stock">Stock</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="stock_min" class="form-control styled-input @error('stock_min') is-invalid @enderror" value="{{ old('stock_min', $producto?->stock_min) }}" placeholder="Stock mínimo">
                        {!! $errors->first('stock_min', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="stock_min">Stock Mínimo</label>
                    </div>

                    @php
                        $fechaVencimiento = old('fecha_vencimiento', $producto->fecha_vencimiento ?? '');
                        if ($fechaVencimiento instanceof \Carbon\Carbon) {
                            $fechaVencimiento = $fechaVencimiento->format('Y-m-d');
                        }
                    @endphp

                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_vencimiento" class="form-control styled-input @error('fecha_vencimiento') is-invalid @enderror" value="{{ $fechaVencimiento }}">
                        {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->

        <div class="form-group mb-3">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
            {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        @if(isset($producto) && $producto->imagen)
        <div class="mb-3">
            <p>Imagen actual:</p>
            <img src="{{ asset('storage/' . $producto->imagen) }}" width="150" alt="Imagen actual">
        </div>
        @endif
        <div class="row">
        <!-- Columna izquierda -->
        <div class="col-md-6">
            <div class="card mb-1 shadow-sm">
        
                <div class="card-body">
        <div class="form-floating mb-3">
            <input list="categorias" name="categoria_nombre" class="form-control styled-input @error('categoria_nombre') is-invalid @enderror" value="{{ old('categoria_nombre', $producto->categoria->nombre ?? '') }}" placeholder="Categoría">
            <datalist id="categorias">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->nombre }}">
                @endforeach
            </datalist>
            {!! $errors->first('categoria_nombre', '<div class="invalid-feedback">:message</div>') !!}
            <label for="categoria_nombre">Categoría</label>
        </div>

        <div class="form-floating mb-3">
            <input list="laboratorios" name="laboratorio_nombre" class="form-control styled-input @error('laboratorio_nombre') is-invalid @enderror" value="{{ old('laboratorio_nombre', $producto->laboratorio->nombre_laboratorio ?? '') }}" placeholder="Laboratorio">
            <datalist id="laboratorios">
                @foreach ($laboratorios as $lab)
                    <option value="{{ $lab->nombre_laboratorio }}">
                @endforeach
            </datalist>
            {!! $errors->first('laboratorio_nombre', '<div class="invalid-feedback">:message</div>') !!}
            <label for="laboratorio_nombre">Laboratorio</label>
        </div>

        <div class="form-floating mb-3">
            <input list="presentaciones" name="presentacion_tipo" class="form-control styled-input @error('presentacion_tipo') is-invalid @enderror" value="{{ old('presentacion_tipo', $producto->presentacion->tipo_presentacion ?? '') }}" placeholder="Presentación">
            <datalist id="presentaciones">
                @foreach ($presentaciones as $pres)
                    <option value="{{ $pres->tipo_presentacion }}">
                @endforeach
            </datalist>
            {!! $errors->first('presentacion_tipo', '<div class="invalid-feedback">:message</div>') !!}
            <label for="presentacion_tipo">Presentación</label>
        </div>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>
<!-- Quill CSS y JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Escribe la descripción...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'align': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }]
            ]
        }
    });

    // Pasar contenido del editor al input oculto al enviar el formulario
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('#descripcion').value = quill.root.innerHTML;
    });
</script>

