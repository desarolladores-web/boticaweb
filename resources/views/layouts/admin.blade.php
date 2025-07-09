<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @vite(['resources/css/admin.css'])

  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <title>Panel de Administración</title>

</head>
<body>

  <!-- Sidebar -->
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <!-- <img src="logo.png" alt=""> -->
        </span>
        <div class="text logo-text">
          <span class="name">Codinglab</span>
          <span class="profession">Web developer</span>
        </div>
      </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>
    <div class="menu-bar">
      <div class="menu">
        <li class="search-box">
          <i class='bx bx-search icon'></i>
          <input type="text" placeholder="Search..." />
        </li>
        <ul class="menu-links">
          <li class="nav-link"><a href="#"><i class='bx bx-home-alt icon'></i><span class="text nav-text">Dashboard</span></a></li>
          <li class="nav-link">
  <a href="{{ route('productos.index') }}">
    <i class='bx bx-package icon'></i>
    <span class="text nav-text">Gestión de Productos</span>
  </a>
</li>
          <li class="nav-link"><a href="#"><i class='bx bx-bell icon'></i><span class="text nav-text">Notificaciones</span></a></li>
          <li class="nav-link"><a href="#"><i class='bx bx-pie-chart-alt icon'></i><span class="text nav-text">Analytics</span></a></li>
          <li class="nav-link"><a href="#"><i class='bx bx-heart icon'></i><span class="text nav-text">Likes</span></a></li>
          <li class="nav-link"><a href="#"><i class='bx bx-wallet icon'></i><span class="text nav-text">Wallets</span></a></li>
        </ul>
      </div>
      <div class="bottom-content">
        <li><a href="#"><i class='bx bx-log-out icon'></i><span class="text nav-text">Logout</span></a></li>
        <li class="mode">
          <div class="sun-moon">
            <i class='bx bx-moon icon moon'></i>
            <i class='bx bx-sun icon sun'></i>
          </div>
          <span class="mode-text text">Dark mode</span>
          <div class="toggle-switch"><span class="switch"></span></div>
        </li>
      </div>
    </div>
  </nav>

  <!-- Main container: navbar + content -->
  <div class="main-container">
  <!-- Navbar al costado del sidebar -->
  <div class="top-navbar">
    <span>Panel de Administración</span>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-light btn-sm">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
    </button>
</form>
  </div>

  <!-- Contenido -->
  <div class="content">
    <h1>Contenido principal</h1>
    <p>Este es el contenido que se muestra al costado del sidebar con la navbar incluida.</p>
  </div>
</div>


  <!-- Script -->
  <script>
    const body = document.querySelector('body'),
          sidebar = document.querySelector('nav.sidebar'),
          toggles = document.querySelectorAll(".toggle"),
          searchBtn = document.querySelector(".search-box"),
          modeSwitch = document.querySelector(".toggle-switch"),
          modeText = document.querySelector(".mode-text");

    toggles.forEach(toggle => {
      toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        document.querySelector('.main-container').classList.toggle('collapsed');
      });
    });

    searchBtn.addEventListener("click", () => {
      sidebar.classList.remove("close");
    });

    modeSwitch.addEventListener("click", () => {
      body.classList.toggle("dark");
      modeText.innerText = body.classList.contains("dark") ? "Light mode" : "Dark mode";
    });
  </script>
@yield('content')
</body>
</html>
