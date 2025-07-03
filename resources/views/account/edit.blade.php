@extends('layouts.app')

@section('body-class', 'page-edit')

@section('content')
  <div class="container">
 
  @vite(['resources/css/edit.css'])


    <div class="row">
    <div class="col-12 col-lg-3">
    <div class="sidebar"> 
    
    <!-- Imagen del avatar desde la tabla clientes (binario) -->
    <div class="avatar text-center">
        @if($cliente && $cliente->imagen)
            <img src="data:image/jpeg;base64,{{ base64_encode($cliente->imagen) }}"
                alt="Avatar"
                class="rounded-circle"
                style="width: 60px; height: 60px; object-fit: cover;">
        @else
            <img src="{{ asset('default-avatar.png') }}"
                alt="Avatar por defecto"
                class="rounded-circle"
                style="width: 60px; height: 60px; object-fit: cover;">
        @endif

        <h5 class="mt-2">Hola {{ $cliente->nombre }}</h5>
        <p class="text-muted" style="font-size: 14px;">{{ $cliente->email }}</p>
    </div>

    <!-- Menú de navegación -->
    <ul class="list-unstyled">
      <li class="mb-3">
        <a href="{{ route('account.edit') }}" class="sidebar-link">
          <i class="bi bi-pen" style="margin-right: 10px;"></i> <span>Editar perfil</span>
        </a>
      </li>
      <li class="mb-3">
        <a href="#" class="sidebar-link">
          <i class="bi bi-box" style="margin-right: 10px;"></i> <span>Pedidos</span>
        </a>
      </li>
      <li class="mb-3">
        <a href="#" class="sidebar-link">
          <i class="bi bi-geo-alt" style="margin-right: 10px;"></i> <span>Direcciones</span>
        </a>
      </li>
      <li class="mb-3">
        <a href="#" class="sidebar-link">
          <i class="bi bi-shield-lock" style="margin-right: 10px;"></i> <span>Contraseña</span>
        </a>
      </li>
      <li class="mb-3">
        <a href="#" class="sidebar-link">
          <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> <span>Cerrar sesión</span>
        </a>
      </li>
    </ul>
  </div>
</div>


      <!-- Main Content -->
      <div class="col-12 col-lg-9">
        <div class="account-card-box addresses-box">
          <!-- Mensajes de éxito y error -->
          @if (session('success'))
            <div class="alert alert-success mt-4">
              {{ session('success') }}
            </div>
          @endif
          @if (session('error'))
            <div class="alert alert-danger mt-4">
              {{ session('error') }}
            </div>
          @endif

          <div class="account-card-title d-flex justify-content-between align-items-center">
            <span class="fw-bold">{{ __('Editar') }} </span>
          </div>

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
    <button class="icon-box" type="button" onclick="verImagen()"style="background: none; border: none; padding: 0;" aria-label="Ver imagen">
      <i class="bi bi-eye"></i>
    </button>

    <!-- Botón de eliminar imagen -->
    <button class="icon-box" type="button" onclick="eliminarImagen({{ $cliente->id }})"style="background: none; border: none; padding: 0;" aria-label="Eliminar imagen">
      <i class="bi bi-trash"></i>
    </button>
  </div>

   

  </label>
</div>

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
        </div>
      </div>
    </div>
  </div>
 
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

  // Función para eliminar la imagen via fetch
  function eliminarImagen(clienteId) {
  fetch(`/account/image/${clienteId}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const preview = document.getElementById('imagen-preview');
      if (preview) preview.remove();

      const deleteBtn = document.querySelector('.icon-box');
      if (deleteBtn) deleteBtn.style.display = 'none';

      
      
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Hubo un error al procesar la solicitud');
  });
}
  // Al cargar la página, ocultar el botón eliminar si no hay imagen
  document.addEventListener('DOMContentLoaded', () => {
    const preview = document.getElementById('imagen-preview');
    const deleteBtn = document.querySelector('.icon-box');

    if (!preview && deleteBtn) {
      deleteBtn.style.display = 'none';
    }
  });
</script>

@endsection
