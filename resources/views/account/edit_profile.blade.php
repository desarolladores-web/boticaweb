<form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <!-- Imagen -->
  <div class="mb-3">
  <label for="imagen" class="form-label">Imagen</label>
  <label for="imagen" class="d-block" style="
    width: 150px;
    height: 150px;
    border: 2px dashed #d63384;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background-color: #f8f9fa;
    overflow: hidden;
    border-radius: 10px;
    position: relative;">
    
    <!-- Input oculto -->
      <input type="file" name="imagen" id="imagen" accept="image/*" style="display: none;" onchange="previewImagen(event)">

    @if($user->imagen)
      <img id="imagen-preview" src="data:image/jpeg;base64,{{ base64_encode($user->imagen) }}" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover;">
    @else
      <span id="placeholder" style="font-size: 45px; color: #6c757d; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">+</span>
    @endif
  



      
      <div class="avatar-icons">
        <!-- Botón de ver imagen -->
        <button class="icon-box" type="button" onclick="verImagen()" style="background: none; border: none; padding: 0;" aria-label="Ver imagen">
          <i class="bi bi-eye"></i>
        </button>

        <!-- Botón de eliminar imagen -->
        <button class="icon-box" type="button" onclick="eliminarImagen({{ $user->id }})" style="background: none; border: none; padding: 0;" aria-label="Eliminar imagen">
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </label>
  </div>

  <!-- Nombre -->
  <div class="mb-3">
    <label for="name" class="form-label"><i class="bi bi-person"></i> {{ __('Nombre') }}</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
  </div>

  <!-- Email -->
  <div class="mb-3">
    <label for="email" class="form-label"><i class="bi bi-envelope"></i> {{ __('Correo Electronico') }}</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
  </div>

  <button type="submit" class="btn btn-pink btn-lg w-50">Editar</button>
</form>
<!-- Modal de imagen -->
<div class="modal fade" id="modalImagen" tabindex="-1" aria-labelledby="modalImagenLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img id="imagenModalVista" src="" alt="Imagen de perfil" style="width: 100%; height: auto; border-radius: 5px;">
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap + SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función para mostrar la imagen en modal
  function verImagen() {
    const imagen = document.getElementById("imagen-preview");
    const modalImg = document.getElementById("imagenModalVista");

    if (imagen && modalImg) {
      modalImg.src = imagen.src;
      const modal = new bootstrap.Modal(document.getElementById('modalImagen'));
      modal.show();
    }
  }

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
        container.insertBefore(img, input);
      }

      document.getElementById('imagen-preview').src = reader.result;

      const deleteBtn = container.querySelector('.icon-box');
      if (deleteBtn) {
        deleteBtn.style.display = 'inline-block';
      }
    };

    reader.readAsDataURL(input.files[0]);
  }

  // Eliminar imagen
  function eliminarImagen(UserId) {
    fetch(`/account/image/${UserId}`, {
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
      } else {
        alert('Error al eliminar la imagen');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Hubo un error al procesar la solicitud');
    });
  }

  // Mostrar SweetAlert2 si hay mensaje de éxito
  document.addEventListener("DOMContentLoaded", function () {
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754', // verde Bootstrap
        background: '#f0f8ff',          // color de fondo suave (opcional)
        color: '#000',                  // texto en negro
        timer: 2500,
        showConfirmButton: false,
        position: 'center'              // 👈 Esto asegura que sea centrado
      });
    @endif
  });
</script>
