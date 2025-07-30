<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="en">
  <head>
    <!-- Tailwind CDN -->


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Side Navigation Bar in HTML CSS JavaScript</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    @vite(['resources/css/admin.css'])
  </head>
  <body>
<!-- navbar -->
<nav class="navbar">
  <!-- Logo e ícono de menú -->
  <div class="logo_item">
    <i class="bx bx-menu" id="sidebarOpen"></i>
    <img src="{{ asset('imagenes/botica2.png') }}" class="img-fluid" alt="Logo"> Botica Myryan
  </div>

  <!-- Barra de búsqueda -->
  <div class="search_bar">
    <input type="text" placeholder="Search" />
  </div>

  <!-- Contenido del navbar -->
  <div class="navbar_content">
    
    <i class='bx bx-sun' id="darkLight"></i>
    <i class='bx bx-bell'></i>

    @auth
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
         id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        @if(Auth::user()->imagen)
          <img src="data:image/jpeg;base64,{{ base64_encode(Auth::user()->imagen) }}"
               alt="Avatar"
               class="rounded-circle"
               style="width: 40px; height: 40px; object-fit: cover;" />
        @else
          <i class="bi bi-person-circle" style="font-size: 1.8rem; color: #555;"></i>
        @endif
      </a>

      <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser">
        <li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
            </button>
          </form>
        </li>
      </ul>
    </div>
    @endauth

  </div>
</nav>



    <!-- Contenedor principal con sidebar y contenido -->
    <div style="display: flex;">
  @if(View::hasSection('admin-sidebar'))
    @yield('admin-sidebar')
  @else
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- start -->
          <li class="item">
            <a href="{{ route('welcome') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-home-alt"></i>
              </span>
              <span class="navlink">Inicio</span>
            </a>
          </li>
          <!-- end -->
          <li class="item">
            <div href="" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="bx bx-grid-alt"></i>
              </span>
              <span class="navlink">Overview</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="#" class="nav_link sublink">Nav Sub Link</a>
              <a href="#" class="nav_link sublink">Nav Sub Link</a>
              <a href="#" class="nav_link sublink">Nav Sub Link</a>
              <a href="#" class="nav_link sublink">Nav Sub Link</a>
            </ul>
          </li>
        </ul>

        <hr class="hr-rojo">

        <ul class="menu_items">
          <div class="menu_title menu_editor"></div>

          <li class="item">
            <a href="{{ route('productos.index') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-package icon"></i>
              </span>
              <span class="navlink">Productos</span>
            </a>
          </li>

          <li class="item">
            <a href="{{ route('empleados.create') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-user-plus ico"></i>
              </span>
              <span class="navlink">Crear Empleados</span>
            </a>
          </li>

          <li class="item">
            <a href="{{ route('admin.account.edit') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-filter"></i>
              </span>
              <span class="navlink">Editar</span>
            </a>
          </li>

          <li class="item">
            <a href="{{ route('usuarios.clientes') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-user"></i>
              </span>
              <span class="navlink">Clientes</span>
            </a>
          </li>
        </ul>

        <hr class="hr-rojo">

        <ul class="menu_items">
          <div class="menu_title menu_setting"></div>

          <li class="item">
            <a href="#" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-flag"></i>
              </span>
              <span class="navlink">Notice board</span>
            </a>
          </li>

          <li class="item">
            <a href="{{ route('usuarios.index') }}" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-group"></i>
              </span>
              <span class="navlink">Empleados</span>
            </a>
          </li>

          <li class="item">
            <a href="#" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-cog"></i>
              </span>
              <span class="navlink">Setting</span>
            </a>
          </li>

          <li class="item">
            <a href="#" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-layer"></i>
              </span>
              <span class="navlink">Features</span>
            </a>
          </li>
        </ul>

        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in'></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
  @endif
</div>

      <!-- Contenido dinámico -->
      <div class="content p-4" style="margin-top: 80px; margin-left: 250px; flex: 1;">
        @yield('content')
      </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript -->
    <script>
      const body = document.querySelector("body");
      const darkLight = document.querySelector("#darkLight");
      const sidebar = document.querySelector(".sidebar");
      const submenuItems = document.querySelectorAll(".submenu_item");
      const sidebarOpen = document.querySelector("#sidebarOpen");
      const sidebarClose = document.querySelector(".collapse_sidebar");
      const sidebarExpand = document.querySelector(".expand_sidebar");

      sidebarOpen.addEventListener("click", () => sidebar.classList.toggle("close"));
      sidebarClose.addEventListener("click", () => {
        sidebar.classList.add("close", "hoverable");
      });
      sidebarExpand.addEventListener("click", () => {
        sidebar.classList.remove("close", "hoverable");
      });
      sidebar.addEventListener("mouseenter", () => {
        if (sidebar.classList.contains("hoverable")) {
          sidebar.classList.remove("close");
        }
      });
      sidebar.addEventListener("mouseleave", () => {
        if (sidebar.classList.contains("hoverable")) {
          sidebar.classList.add("close");
        }
      });
      darkLight.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
          darkLight.classList.replace("bx-sun", "bx-moon");
        } else {
          darkLight.classList.replace("bx-moon", "bx-sun");
        }
      });
      submenuItems.forEach((item, index) => {
        item.addEventListener("click", () => {
          item.classList.toggle("show_submenu");
          submenuItems.forEach((item2, index2) => {
            if (index !== index2) {
              item2.classList.remove("show_submenu");
            }
          });
        });
      });
      if (window.innerWidth < 768) {
        sidebar.classList.add("close");
      } else {
        sidebar.classList.remove("close");
      }
      
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
  </body>
  
</html>
