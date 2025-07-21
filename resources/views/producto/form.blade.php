
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



<div class="container-fluid">
  <div class="row">
    <!-- 🟦 Columna izquierda -->
    <div class="col-md-6">
    <div class="card mt-5 mb-3 shadow-sm p-3">

        <div class="card-body">

          <!-- Categoría -->
          <div class="form-floating mb-3">
            <input list="categorias" name="categoria_nombre" class="form-control styled-input @error('categoria_nombre') is-invalid @enderror" 
              value="{{ old('categoria_nombre', $producto->categoria->nombre ?? '') }}" placeholder="Categoría">
            <datalist id="categorias">
              @foreach ($categorias as $categoria)
                <option value="{{ $categoria->nombre }}">
              @endforeach
            </datalist>
            <label for="categoria_nombre">Categoría</label>
            {!! $errors->first('categoria_nombre', '<div class="invalid-feedback">:message</div>') !!}
          </div>

          <!-- Laboratorio -->
          <div class="form-floating mb-3">
            <input list="laboratorios" name="laboratorio_nombre" class="form-control styled-input @error('laboratorio_nombre') is-invalid @enderror" 
              value="{{ old('laboratorio_nombre', $producto->laboratorio->nombre_laboratorio ?? '') }}" placeholder="Laboratorio">
            <datalist id="laboratorios">
              @foreach ($laboratorios as $lab)
                <option value="{{ $lab->nombre_laboratorio }}">
              @endforeach
            </datalist>
            <label for="laboratorio_nombre">Laboratorio</label>
            {!! $errors->first('laboratorio_nombre', '<div class="invalid-feedback">:message</div>') !!}
          </div>

          <!-- Presentación -->
          <div class="form-floating mb-3">
            <input list="presentaciones" name="presentacion_tipo" class="form-control styled-input @error('presentacion_tipo') is-invalid @enderror" 
              value="{{ old('presentacion_tipo', $producto->presentacion->tipo_presentacion ?? '') }}" placeholder="Presentación">
            <datalist id="presentaciones">
              @foreach ($presentaciones as $pres)
                <option value="{{ $pres->tipo_presentacion }}">
              @endforeach
            </datalist>
            <label for="presentacion_tipo">Presentación</label>
            {!! $errors->first('presentacion_tipo', '<div class="invalid-feedback">:message</div>') !!}
          </div>

        </div>
      </div>
    </div>

    <!-- 🟩 Columna derecha -->
    <div class="col-md-6">
      
      <div class="card mb-3 shadow-sm p-3">
      <div class="card-header">
      <h5 class="mb-0">Imagen del Producto</h5>
      </div>
        <div class="card-body">
          

          <!-- Formulario de carga de imagen -->
          <form class="file-upload-form">
  <label for="file" class="file-upload-label">
    <div class="file-upload-text">
      <svg viewBox="0 0 640 512">
        <path
          d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"
        ></path>
      </svg>
      <p>Arrastrar y soltar Imagen</p>
      <p>o</p>
      <span class="browse-button">Eplorar imagen</span>
    </div>
    <input id="file" type="file" name="imagen" accept="image/*" onchange="previewImage(event)">
    <img id="preview" class="file-upload-preview" alt="Vista previa" />
  </label>
  <div style="text-align: center; margin-top: 10px;">
    <button type="button" class="delete-button" id="deleteBtn" style="display: none;">Eliminar archivo</button>
  </div>
</form>


          <!-- Mostrar imagen actual -->
          @if(isset($producto) && $producto->imagen)
            <div class="img-preview mt-3 text-center">
              <p>Imagen actual:</p>
              <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-thumbnail" style="max-width: 200px;" alt="Imagen actual">
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  <!-- 🔘 Botón Guardar -->
  <div class="d-flex justify-content-between text-center ">
                        <button type="button" class="btn btn-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
    function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const deleteBtn = document.getElementById('deleteBtn');

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        deleteBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  document.getElementById('deleteBtn').addEventListener('click', function () {
    const input = document.getElementById('file');
    const preview = document.getElementById('preview');
    input.value = '';
    preview.src = '';
    preview.style.display = 'none';
    this.style.display = 'none';
  });
    
</script>

