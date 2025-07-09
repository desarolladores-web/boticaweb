<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @vite(['resources/css/admin.css'])

  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>

  <!-- Sidebar -->
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="{{ asset('imagenes/botica2.png') }}" class="img-fluid" alt="Logo"> 
        </span>
       <div class="text logo-text" style="position: absolute; left: 100px;">
  <span class="name">Botica</span>
  <span class="profession">Mirian</span>
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
          <li class="nav-link">
            <a href="#"><i class='bx bx-home-alt icon'></i><span class="text nav-text">Dashboard</span></a>
          </li>
          <li class="nav-link">
            <a href="{{ route('productos.index') }}"><i class='bx bx-package icon'></i><span class="text nav-text">Productos</span></a>
          </li>
          <li class="nav-link">
            <a href="#"><i class='bx bx-bell icon'></i><span class="text nav-text">Notificaciones</span></a>
          </li>
          <li class="nav-link">
            <a href="#"><i class='bx bx-pie-chart-alt icon'></i><span class="text nav-text">Analytics</span></a>
          </li>
          <li class="nav-link">
            <a href="#"><i class='bx bx-heart icon'></i><span class="text nav-text">Likes</span></a>
          </li>
          <li class="nav-link">
            <a href="#"><i class='bx bx-wallet icon'></i><span class="text nav-text">Wallets</span></a>
          </li>
        </ul>
      </div>

      <div class="bottom-content">
        <li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>

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
    <!-- Navbar -->
    <div class="top-navbar">
      <!-- Puedes agregar aquí el contenido del navbar si deseas -->
    </div>

    <!-- Contenido principal -->
    <div class="content">
      @yield('content')
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

</body>
</html>
