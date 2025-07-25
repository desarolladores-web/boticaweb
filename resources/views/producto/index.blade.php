

@extends('layouts.admin')

@section('template_title')
    Productos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Productos') }}</h5>
                    
                </div>

                {{-- Mensajes de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

        {{-- Formulario de búsqueda, importación y creación horizontal --}}
<div class="card-body border-top">
    <div class="d-flex flex-wrap align-items-center gap-3">

        {{-- Formulario de búsqueda --}}
        <form action="{{ route('productos.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            {{-- Filtro por categoría --}}
            <select name="categoria_id" class="form-select form-select-sm w-auto">
                <option value="">-- Todas las Categorías --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>

            {{-- Búsqueda por nombre --}}
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm w-auto" placeholder="Buscar producto...">

            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-search me-1"></i> Buscar
            </button>

            <a href="{{ route('productos.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-x-circle me-1"></i> Limpiar
            </a>
        </form>

        {{-- Formulario de importación --}}
        <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" class="form-control form-control-sm w-auto" required>
            <button type="submit"
                <i class="bi bi-upload me-1"></i> Importar
            </button>
        </form>

        {{-- Formulario de creación --}}
             <form action="{{ route('productos.create') }}" method="GET" class="d-flex">
    <button type="submit">
        <i class="bi bi-plus-circle me-1"></i> Agregar Producto
    </button>
</form> 

    </div>
</div>




  
{{-- Estilos personalizados --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .modern-table-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-size: 0.9rem;
    }

    .modern-table thead th {
        text-align: left;
        padding: 12px;
        color: #555;
        font-weight: 600;
    }

    .modern-table tbody td {
        background-color: #f5f5f5ff;
        padding: 14px;
        vertical-align: middle;
        border-radius: 8px;
    }

    .img-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-icon {
        padding: 6px 10px;
        font-size: 0.8rem;
        margin-right: 4px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 6px;
    }

    .btn-icon i {
        font-size: 14px;
    }

    .text-muted {
        color: #999 !important;
    }
</style>

{{-- Tabla de productos --}}
<div class="modern-table-container">
    <h4 class="mb-4">Listado de Productos</h4>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Principio Activo</th>
                    <th>PVP1</th>
                    <th>Precio Costo</th>
                    <th>Stock</th>
                    <th>Stock Min</th>
                    <th>Vencimiento</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Laboratorio</th>
                    <th>Presentación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->principio_activo }}</td>
                        <td>S/ {{ number_format($producto->pvp1, 2) }}</td>
                        <td>S/ {{ number_format($producto->precio_costo_unitario, 2) }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $producto->stock_min }}</td>
                        <td>{{ $producto->fecha_vencimiento }}</td>
                        <td>
                            @if ($producto->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-thumb" alt="Producto">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>{{ $producto->laboratorio->nombre_laboratorio ?? 'Sin laboratorio' }}</td>
                        <td>{{ $producto->presentacion->nombre ?? 'Sin presentación' }}</td>
                        <td>
                          <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-flex gap-2 align-items-center">
    <a class="btn btn-light btn-sm rounded-circle shadow-sm" href="{{ route('productos.show', $producto->id) }}" title="Ver">
        <i class="bi bi-eye fs-5"></i>
    </a>
    <a class="btn btn-light btn-sm rounded-circle shadow-sm" href="{{ route('productos.edit', $producto->id) }}" title="Editar">
        <i class="bi bi-pencil fs-5"></i>
    </a>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm" title="Eliminar"
        onclick="event.preventDefault(); if (confirm('¿Eliminar producto?')) this.closest('form').submit();">
        <i class="bi bi-trash3 fs-5"></i>
    </button>
</form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


                {{-- Paginación --}}
      <div class="card-footer d-flex justify-content-center">
    <nav>
        <ul class="inline-flex items-center -space-x-px">
            {{-- Botón "Primero" --}}
            <li>
                <a href="{{ $productos->url(1) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300">
                    <i class="bi bi-skip-backward-fill"></i>
                </a>
            </li>

            {{-- Botón "Anterior" --}}
            <li>
                <a href="{{ $productos->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

          @php
    $totalPages = $productos->lastPage();
    $currentPage = $productos->currentPage();

    // Rango que se mostrará
    $start = max(1, $currentPage - 2);
    $end = min($totalPages, $currentPage + 2);

    // Ajustar si estamos cerca del inicio o del final
    if ($currentPage <= 3) {
        $end = min(5, $totalPages);
    }

    if ($currentPage >= $totalPages - 2) {
        $start = max(1, $totalPages - 4);
    }
@endphp


{{-- Mostrar rango de páginas --}}
@for ($i = $start; $i <= $end; $i++)
    @if ($i == $currentPage)
        <li>
            <span class="w-10 h-10 flex items-center justify-center rounded-full text-white font-semibold" style="background-color: #ff0000;">
                {{ $i }}
            </span>
        </li>
    @else
        <li>
            <a href="{{ $productos->url($i) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                {{ $i }}
            </a>
        </li>
    @endif
@endfor




            {{-- Botón "Siguiente" --}}
            <li>
                <a href="{{ $productos->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>

            {{-- Botón "Último" --}}
            <li>
                <a href="{{ $productos->url($productos->lastPage()) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300">
                    <i class="bi bi-skip-forward-fill"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>


<script src="https://cdn.tailwindcss.com"></script>

            </div>
        </div>
    </div>
</div>
@endsection
