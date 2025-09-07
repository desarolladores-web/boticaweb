@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📦 stock de productos</h5>
        </div>
        <div class="card-body">

            <!-- 🔹 Filtro -->
            <form method="GET" action="{{ route('admin.productos.agotados') }}" class="row g-3 mb-4">
                <div class="col-md-4 rounded-4 ">
                    <select name="estado" class="form-select" onchange="this.form.submit()">
                        <option value=""> Filtro de stock </option>
                        <option value="agotado" {{ request('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="bajo" {{ request('estado') == 'bajo' ? 'selected' : '' }}>Bajo stock</option>
                        <option value="suficiente" {{ request('estado') == 'suficiente' ? 'selected' : '' }}>Stock suficiente</option>
                    </select>
                </div>
            </form>

            <!-- 🔹 Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Stock mínimo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr class="text-center">
                                <td>{{ $producto->codigo }}</td>
                                <td class="text-start">{{ $producto->nombre }}</td>
                                <td><span class="fw-bold">{{ $producto->stock }}</span></td>
                                <td>{{ $producto->stock_min }}</td>
                                <td>
                                    @if($producto->stock <= 0)
                                        <span class="badge bg-danger">Agotado</span>
                                    @elseif($producto->stock <= $producto->stock_min)
                                        <span class="badge bg-warning text-dark">Bajo stock</span>
                                    @else
                                        <span class="badge bg-success">Stock suficiente</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editarStockModal"
                                            data-id="{{ $producto->id }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-stock="{{ $producto->stock }}">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info m-0">
                                        ✅ No hay productos en este estado.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $productos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- 🔹 Modal para editar stock -->
<div class="modal fade" id="editarStockModal" tabindex="-1" aria-labelledby="editarStockLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.productos.updateStock') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="producto_id">

        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="editarStockLabel">Editar Stock</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="producto_nombre" class="form-label">Producto</label>
                  <input type="text" id="producto_nombre" class="form-control" readonly>
              </div>
              <div class="mb-3">
                  <label for="nuevo_stock" class="form-label">Nuevo Stock</label>
                  <input type="number" name="stock" id="nuevo_stock" class="form-control" min="0" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar cambios</button>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Script modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editarStockModal = document.getElementById('editarStockModal');
    editarStockModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        var stock = button.getAttribute('data-stock');

        document.getElementById('producto_id').value = id;
        document.getElementById('producto_nombre').value = nombre;
        document.getElementById('nuevo_stock').value = stock;
    });
});
</script>
@endsection
