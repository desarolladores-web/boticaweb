@extends('layouts.admin')
@vite(['resources/css/edit.css'])

@section('content')
<div class="container">
  <h1 class="mb-4">Panel de Administración</h1>

  <div class="row">
    <!-- Sidebar de administración -->
    <div class="col-lg-3 bg-light p-4 shadow-sm" style="min-height: 100vh;">
      <div class="sidebar">
        <ul class="list-unstyled">
          <li class="mb-3">
            <a href="{{ route('productos.index') }}" class="sidebar-link d-flex align-items-center">
              <i class="fas fa-box me-2"></i> <span>Gestionar Productos</span>
            </a>
          </li>
          <ul class="list-unstyled">
          <li class="mb-3">
            <a href="#" class="sidebar-link d-flex ">
              <i class="fas fa-users-cog me-2"></i> <span>Gestionar Usuarios</span>
            </a>
            </ul>
          </li>
          <li class="mb-4">
            <a href="#" class="sidebar-link d-flex ">
              <i class="fas fa-user me-2"></i> <span>Ver Usuarios</span>
            </a>
          </li>
          <li class="mb-3">
            <a href="#" class="sidebar-link d-flex align-items-center">
              <i class="fas fa-shopping-cart me-2"></i> <span>Ventas</span>
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('logout') }}" class="sidebar-link d-flex align-items-center"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt me-2"></i> <span>Cerrar sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>

    <!-- Contenido principal -->
    <div class="col-12 col-lg-9">
      <!-- Aquí podrías colocar otros elementos del panel -->
      <p class="text-muted">Bienvenido al panel de administración.</p>
    </div>
  </div>
</div>
@endsection
