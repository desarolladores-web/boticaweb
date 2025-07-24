@extends('layouts.admin')

@section('template_title')
    Productos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span id="card_title">
                        {{ __('Productos') }}
                    </span>
                    </div>
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
       <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                {{-- Formulario de importación --}}
                <div class="card-body border-bottom">
                   <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="archivo" required>
    <button type="submit">Importar</button>
</form>

                </div>

                {{-- Tabla de productos --}}
                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Principio Activo</th>
                                    <th>PVP1</th>
                                    <th>Precio Costo Unitario</th>
                                    <th>Stock</th>
                                    <th>Stock Min</th>
                                    <th>Fecha Vencimiento</th>
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
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->descripcion }}</td>
                                        <td>{{ $producto->principio_activo }}</td>
                                        <td>{{ $producto->pvp1 }}</td>
                                        <td>{{ $producto->precio_costo_unitario }}</td>
                                        <td>{{ $producto->stock }}</td>
                                        <td>{{ $producto->stock_min }}</td>
                                        <td>{{ $producto->fecha_vencimiento }}</td>
                                        <td>
    @if ($producto->imagen)
        <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" alt="Imagen del producto" width="80">
    @else
        Sin imagen
    @endif
</td>
                                        <td>{{ $producto->categoria_id }}</td>
                                        <td>{{ $producto->laboratorio_id }}</td>
                                        <td>{{ $producto->presentacion_id }}</td>
                                        <td>
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('productos.show', $producto->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> {{ __('Show') }}
                                                </a>
                                                <a class="btn btn-sm btn-success" href="{{ route('productos.edit', $producto->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="event.preventDefault(); if (confirm('¿Estás seguro de eliminar este producto?')) this.closest('form').submit();">
                                                    <i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}
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
        {{ $productos->appends(request()->query())->links('pagination::bootstrap-5') }}
    </nav>
</div>


            </div>
        </div>
    </div>
</div>
@endsection
