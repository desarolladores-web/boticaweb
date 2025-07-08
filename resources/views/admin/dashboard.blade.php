@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Panel de Administración</h1>

    <a href="{{ route('productos.index') }}" class="btn btn-primary">
        <i class="fas fa-box"></i> Gestionar Productos
    </a>

    <a href="#" class="btn btn-secondary">
        <i class="fas fa-users"></i> Gestionar Usuarios
    </a>

    <a href="#" class="btn btn-success">
        <i class="fas fa-shopping-cart"></i> Ver Ventas
    </a>
@endsection
