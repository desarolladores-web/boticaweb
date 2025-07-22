@extends('layouts.admin')

@section('template_title')
    Productos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Productos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="archivo" class="form-control" required>
    <button type="submit" class="btn btn-primary mt-2">
        <i class="fas fa-file-import"></i> Importar Excel
    </button>
</form>
                              
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Codigo</th>
									<th >Nombre</th>
									<th >Descripcion</th>
									<th >Principio Activo</th>
									<th >Pvp1</th>
									<th >Precio Costo Unitario</th>
									<th >Stock</th>
									<th >Stock Min</th>
									<th >Fecha Vencimiento</th>
									<th >Imagen</th>
									<th >Categoria Id</th>
									<th >Laboratorio Id</th>
									<th >Presentacion Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $producto->codigo }}</td>
										<td >{{ $producto->nombre }}</td>
										<td >{{ $producto->descripcion }}</td>
										<td >{{ $producto->principio_activo }}</td>
										<td >{{ $producto->pvp1 }}</td>
										<td >{{ $producto->precio_costo_unitario }}</td>
										<td >{{ $producto->stock }}</td>
										<td >{{ $producto->stock_min }}</td>
										<td >{{ $producto->fecha_vencimiento }}</td>
										<td >{{ $producto->imagen }}</td>
										<td >{{ $producto->categoria_id }}</td>
										<td >{{ $producto->laboratorio_id }}</td>
										<td >{{ $producto->presentacion_id }}</td>

                                            <td>
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('productos.show', $producto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('productos.edit', $producto->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
       
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $productos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
