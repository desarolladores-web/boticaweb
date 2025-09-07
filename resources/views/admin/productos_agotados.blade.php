@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📦 Productos con alertas de stock</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
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
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->stock }}</td>
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
                                <!-- Botón para abrir el modal -->
                                <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editarStockModal" 
                                        data-id="{{ $producto->id }}" 
                                        data-nombre="{{ $producto->nombre }}" 
                                        data-stock="{{ $producto->stock }}">
                                    Editar Stock
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($productos->isEmpty())
                <div class="alert alert-info text-center">
                    ✅ No hay productos agotados ni con stock bajo.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para editar stock -->
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

<!-- Script para pasar datos al modal -->
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
