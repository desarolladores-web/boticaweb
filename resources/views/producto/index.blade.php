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
                    <h1 class="mb-0">{{ __('Productos') }}</h1>

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

                        <form action="{{ route('productos.index') }}" method="GET" class="d-flex align-items-center gap-2">
                            <select name="categoria_id"
                                class="form-control styled-input w-auto @error('categoria_id') is-invalid @enderror"
                                id="categoria_id">
                                <option value="" disabled selected>Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                                @endforeach
                            </select>

                            <div class="right">
                                <form action="{{ route('productos.buscar') }}" method="get" class="search-group">
                                    <input type="text" class="form-control styled-input" name="buscar" placeholder="Buscar"
                                        value="{{ request('buscar') }}">
                                    <button type="submit" class="btn">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
                            </div>




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
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                <style>
                    .table-red-lines {
                        border-collapse: collapse;
                        /* Cambiado de 'separate' a 'collapse' */
                        width: 100%;
                        border-radius: 8px;
                        overflow: hidden;
                    }

                    /* Título de la tabla */
                    .table-title {
                        font-size: 1.4rem;
                        font-weight: bold;
                        color: #000;
                        margin-bottom: 1rem;
                        border-left: 5px solid #b30000;
                        padding-left: 10px;
                    }

                    /* Cabecera moderna en rojo degradado */
                    .table-red-lines thead th {
                        background: linear-gradient(to right, #ca2020, #cc2626);
                        color: white;
                        padding: 12px;
                        font-weight: 600;
                        font-size: 14px;
                        text-transform: uppercase;
                        border: none;
                    }

                    .table-red-lines tbody td {
                        background-color: #ffffffff;
                        /* Fondo claro */
                        padding: 10px;
                        border-radius: 4px;
                        border-bottom: 1px solid #000000;
                        /* Línea negra horizontal */
                    }

                    /* Fila del cuerpo de tabla */
                    .table-red-lines tbody tr {
                        background-color: #0000004b !important;
                        /* plomo claro */
                        border-bottom: 1px solid rgba(196, 196, 196, 0.86);
                        /* línea roja horizontal */
                        transition: background 0.3s ease;
                    }

                    /* Hover sobre fila */
                    .table-red-lines tbody tr:hover {
                        background-color: #f9dcdc;
                        /* rojo suave al pasar mouse */
                    }

                    /* Celdas */
                    .table-red-lines tbody td {
                        padding: 10px;
                        vertical-align: middle;
                        border: none;
                    }

                    .table-red-lines th,
                    .table-red-lines td {
                        text-align: center;
                    }

                    /* Texto pequeño en descripción */
                    .table-red-lines small {
                        font-size: 0.85rem;
                        color: #666;
                    }

                    /* Imagen miniatura */
                    .img-thumb {
                        width: 70px;
                        height: 70px;
                        object-fit: cover;
                        border-radius: 8px;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                    }

                    /* Íconos de acciones */
                    .table-actions .btn i,
                    .icon-btn {
                        font-size: 1.3rem;
                        /* íconos un poco más grandes */
                        color: #000;
                        transition: color 0.3s ease;
                    }

                    .table-actions .btn i:hover,
                    .icon-btn:hover {
                        color: #dc3545;
                        /* rojo al pasar */
                    }
                </style>

                <h4 class="table-title">📋 Listado de Productos</h4>


                <div class="table-responsive">
                    <table class="table table-red-lines text-center w-100">
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo }}</td>
                                <td class="fw-bold">{{ $producto->nombre }}</td>
                                <td><small>{{ $producto->descripcion }}</small></td>
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
                                <td class="table-actions">
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                        <a class="btn btn-sm" href="{{ route('productos.show', $producto->id) }}" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a class="btn btn-sm" href="{{ route('productos.edit', $producto->id) }}" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" title="Eliminar"
                                            onclick="event.preventDefault(); if (confirm('¿Eliminar producto?')) this.closest('form').submit();">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                $end=min(5, $totalPages);
                                }

                                if ($currentPage>= $totalPages - 2) {
                                $start = max(1, $totalPages - 4);
                                }
                                @endphp


                                {{-- Mostrar rango de páginas --}}
                                @for ($i = $start; $i <= $end; $i++)
                                    @if ($i==$currentPage)
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