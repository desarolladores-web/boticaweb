<form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <!-- Imagen -->
  <div class="mb-3">
    <label for="imagen" class="form-label">Imagen</label>
    <label for="imagen" class="d-block" style="width: 120px; height: 120px; border: 2px dashed #d63384; display: flex; align-items: center; justify-content: center; cursor: pointer; background-color: #f8f9fa; overflow: hidden; border-radius: 10px; position: relative;">
      <input type="file" name="imagen" id="imagen" accept="image/*" style="display: none;" onchange="previewImagen(event)">
      @if($cliente->imagen)
        <img id="imagen-preview" src="data:image/jpeg;base64,{{ base64_encode($cliente->imagen) }}" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover;">
      @else
        <span id="placeholder" style="font-size: 36px; color: #6c757d;">+</span>
      @endif
      <div class="avatar-icons">
        <!-- Botón de ver imagen -->
        <button class="icon-box" type="button" onclick="verImagen()" style="background: none; border: none; padding: 0;" aria-label="Ver imagen">
          <i class="bi bi-eye"></i>
        </button>

        <!-- Botón de eliminar imagen -->
        <button class="icon-box" type="button" onclick="eliminarImagen({{ $cliente->id }})" style="background: none; border: none; padding: 0;" aria-label="Eliminar imagen">
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </label>
  </div>

  <!-- Nombre -->
  <div class="mb-3">
    <label for="name" class="form-label"><i class="bi bi-person"></i> {{ __('Nombre') }}</label>
    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
  </div>

  <!-- Email -->
  <div class="mb-3">
    <label for="email" class="form-label"><i class="bi bi-envelope"></i> {{ __('Correo Electronico') }}</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
  </div>

  <button type="submit" class="btn btn-pink btn-lg w-50">Editar</button>
</form>
<script>
  // Mostrar vista previa de la imagen seleccionada
  function previewImagen(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function () {
      let container = input.parentElement;
      let existingPreview = document.getElementById('imagen-preview');

      if (!existingPreview) {
        const img = document.createElement('img');
        img.id = 'imagen-preview';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '0';

        // Insertar la imagen antes del input
        container.insertBefore(img, input);
      }

      // Actualizar la fuente de la imagen
      document.getElementById('imagen-preview').src = reader.result;

      // Mostrar el botón eliminar (lo hacemos visible)
      const deleteBtn = container.querySelector('.icon-box');
      if (deleteBtn) {
        deleteBtn.style.display = 'inline-block';
      }
    };

    reader.readAsDataURL(input.files[0]);
  }

  function eliminarImagen(clienteId) {
  fetch(`/account/image/${clienteId}`, { // Asegúrate de usar comillas invertidas (backticks) para interpolación de variables
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}' // Se mantiene el CSRF token
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const preview = document.getElementById('imagen-preview');
      if (preview) preview.remove(); // Eliminar la vista previa de la imagen

      const deleteBtn = document.querySelector('.icon-box');
      if (deleteBtn) deleteBtn.style.display = 'none'; // Ocultar el botón de eliminar imagen
    } else {
      alert('Error al eliminar la imagen');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Hubo un error al procesar la solicitud');
  });
}
  
</script>