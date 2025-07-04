
<form method="POST" action="{{ route('account.password.update') }}">
  @csrf
  @method('PUT')

  <!-- Contraseña Actual -->
  <div class="mb-3">
    <label for="current_password" class="form-label"><i class="bi bi-lock"></i> {{ __('Contraseña Actual') }}</label>
    <input type="password" class="form-control" id="current_password" name="current_password" required>
  </div>

  <!-- Nueva Contraseña -->
  <div class="mb-3">
    <label for="new_password" class="form-label"><i class="bi bi-lock"></i> {{ __('Nueva Contraseña') }}</label>
    <input type="password" class="form-control" id="new_password" name="new_password" required>
  </div>

  <!-- Confirmar Nueva Contraseña -->
  <div class="mb-3">
    <label for="new_password_confirmation" class="form-label"><i class="bi bi-lock"></i> {{ __('Confirmar Nueva Contraseña') }}</label>
    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
  </div>

  <button type="submit" class="btn btn-pink btn-lg w-50">Actualizar Contraseña</button>
</form>
