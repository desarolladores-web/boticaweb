
<style>
    input:focus,
    textarea:focus,
    select:focus {
        border-color: #dc3545!important;
        box-shadow: 0 0 0 0.2rem rgba(248, 2, 2, 0.25) !important;
    }
</style>


<div class="container">
    <div class="row">
        <!-- Información del producto -->
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Información del producto</h5>
                    <small class="text-muted">Pedidos realizados en su tienda</small>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $producto?->codigo) }}" placeholder="Código">
                        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto?->nombre) }}" placeholder="Nombre">
                        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
<div class="form-group mb-3">
    <label for="descripcion">Descripción (opcional)</label>

    <!-- Editor visible -->
    <div id="editor" style="height: 200px; background: #fff; border: 1px solid #ced4da; border-radius: 0.375rem; padding: 10px;">
        {!! old('descripcion', $producto?->descripcion) !!}
    </div>

    <!-- Campo oculto para enviar la data al backend -->
    <input type="hidden" name="descripcion" id="descripcion">
    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
</div>


                </div>
            </div>
        </div>
    </div>
</div>


        <div class="form-group mb-3">
            <label for="principio_activo">Principio Activo</label>
            <input type="text" name="principio_activo" class="form-control @error('principio_activo') is-invalid @enderror" value="{{ old('principio_activo', $producto?->principio_activo) }}" placeholder="Principio Activo">
            {!! $errors->first('principio_activo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="pvp1">PVP1</label>
            <input type="text" name="pvp1" class="form-control @error('pvp1') is-invalid @enderror" value="{{ old('pvp1', $producto?->pvp1) }}" placeholder="PVP1">
            {!! $errors->first('pvp1', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="precio_costo_unitario">Precio Costo Unitario</label>
            <input type="text" name="precio_costo_unitario" class="form-control @error('precio_costo_unitario') is-invalid @enderror" value="{{ old('precio_costo_unitario', $producto?->precio_costo_unitario) }}" placeholder="Precio Costo Unitario">
            {!! $errors->first('precio_costo_unitario', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="stock">Stock</label>
            <input type="text" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto?->stock) }}" placeholder="Stock">
            {!! $errors->first('stock', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="stock_min">Stock Mínimo</label>
            <input type="text" name="stock_min" class="form-control @error('stock_min') is-invalid @enderror" value="{{ old('stock_min', $producto?->stock_min) }}" placeholder="Stock mínimo">
            {!! $errors->first('stock_min', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

    <div class="col-md-6">

        @php
            $fechaVencimiento = old('fecha_vencimiento', $producto->fecha_vencimiento ?? '');
            if ($fechaVencimiento instanceof \Carbon\Carbon) {
                $fechaVencimiento = $fechaVencimiento->format('Y-m-d');
            }
        @endphp

        <div class="form-group mb-3">
            <label for="fecha_vencimiento">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control @error('fecha_vencimiento') is-invalid @enderror" value="{{ $fechaVencimiento }}">
            {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>

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

        <div class="form-group mb-3">
            <label for="categoria_nombre">Categoría</label>
            <input list="categorias" name="categoria_nombre" class="form-control @error('categoria_nombre') is-invalid @enderror" value="{{ old('categoria_nombre', $producto->categoria->nombre ?? '') }}" placeholder="Categoría">
            <datalist id="categorias">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->nombre }}">
                @endforeach
            </datalist>
            {!! $errors->first('categoria_nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="laboratorio_nombre">Laboratorio</label>
            <input list="laboratorios" name="laboratorio_nombre" class="form-control @error('laboratorio_nombre') is-invalid @enderror" value="{{ old('laboratorio_nombre', $producto->laboratorio->nombre_laboratorio ?? '') }}" placeholder="Laboratorio">
            <datalist id="laboratorios">
                @foreach ($laboratorios as $lab)
                    <option value="{{ $lab->nombre_laboratorio }}">
                @endforeach
            </datalist>
            {!! $errors->first('laboratorio_nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="presentacion_tipo">Presentación</label>
            <input list="presentaciones" name="presentacion_tipo" class="form-control @error('presentacion_tipo') is-invalid @enderror" value="{{ old('presentacion_tipo', $producto->presentacion->tipo_presentacion ?? '') }}" placeholder="Presentación">
            <datalist id="presentaciones">
                @foreach ($presentaciones as $pres)
                    <option value="{{ $pres->tipo_presentacion }}">
                @endforeach
            </datalist>
            {!! $errors->first('presentacion_tipo', '<div class="invalid-feedback">:message</div>') !!}
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

