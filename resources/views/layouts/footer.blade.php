<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <!-- Enlace al archivo CSS -->
    @vite(['resources/sass/footer.scss'])

</head>
<footer id="appFooter">
    <div class="footer-box">
        <div class="container">
            <div class="footer-top-links">
                <div class="row">

                    <!-- SOBRE NOSOTROS -->
                    <div class="col-12 col-md-6 col-lg-4 footer-item">
                        <div class="about">
                            <div class="footer-link-title">
                                <span>SOBRE NOSOTROS</span>
                                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                            </div>
                            <div class="about-text footer-item-content text-white">
                                <p>
                                    <b>Botica Myryan ofrece atención personalizada, orientación confiable y productos de
                                        calidad, priorizando la salud como su mayor valor.</b>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCTOS -->
                    <div class="col-12 col-md-6 col-lg-3 footer-item">
                        <div class="footer-links">
                            <div class="footer-link-title">
                                <span>Productos</span>
                                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                            </div>
                            <!-- Caja con scroll -->
                            <div class="footer-scroll">
                                <ul class="footer-item-content">

                                    {{-- Todos los productos --}}
                                    <li>
                                        <a href="{{ route('productos.filtro') }}"
                                            class="{{ request('categorias') ? '' : 'fw-bold text-white' }}">
                                            Todos
                                        </a>
                                    </li>

                                    {{-- Categorías dinámicas --}}
                                    @foreach ($categorias as $categoria)
                                        @php
                                            $activa =
                                                is_array(request('categorias')) &&
                                                in_array($categoria->id, request('categorias'));
                                        @endphp
                                        <li>
                                            <a href="{{ route('productos.filtro', array_merge(request()->except('page', 'categorias'), ['categorias[]' => $categoria->id])) }}"
                                                class="{{ $activa ? 'fw-bold text-success' : '' }}">
                                                {{ $categoria->nombre }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>




                    <!-- CONTÁCTANOS -->
                    <div class="col-12 col-md-6 col-lg-3 footer-item">
                        <div class="footer-links">
                            <div class="footer-link-title">
                                <span>Contáctanos</span>
                                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                            </div>
                            <ul class="footer-item-content">
                                <li>
                                    <a href="https://wa.me/51914819120" target="_blank">
                                        <i class="bi bi-whatsapp me-1"></i> +51 914819120
                                    </a>
                                </li>
                                <li>
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=boticamyryan203@gmail.com"
                                        target="_blank">
                                        <i class="bi bi-envelope-fill me-1"></i> boticamyryan203@gmail.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- SÍGUENOS -->
                    <div class="col-12 col-md-6 col-lg-2 footer-item">
                        <div class="footer-links">
                            <div class="footer-link-title">
                                <span>Síguenos</span>
                                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                            </div>
                            <ul class="footer-item-center social-icons">
                                <li>
                                    <a href="https://www.facebook.com/share/1C77FGP1bi/" target="_blank">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- PARTE INFERIOR -->
            <div class="bottom-box">
                <div class="row">
                    <div class="col-md-7">
                        <div class="left-links">
                            Botica Myryan - R.U.C. N° 20608430301
                            <span class="copyright-text"> |
                                © 2025 Botica Myryan. Todos los derechos reservados.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="payment-icon">
                            <img src="{{ asset('imagenes/payment/1.png') }}" class="img-fluid" alt="Payment Icon">
                            <img src="{{ asset('imagenes/payment/2.png') }}" class="img-fluid" alt="Payment Icon">
                            <img src="{{ asset('imagenes/payment/3.png') }}" class="img-fluid" alt="Payment Icon">
                            <img src="{{ asset('imagenes/payment/4.png') }}" class="img-fluid" alt="Payment Icon">
                            <img src="{{ asset('imagenes/payment/5.png') }}" class="img-fluid" alt="Payment Icon">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* ==== ICONOS SOCIALES ==== */
    .footer-item-center.social-icons {
        display: flex;
        justify-content: flex-start;
        gap: 0px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-item-center.social-icons li a {
        font-size: 1.6rem;
        color: white;
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .footer-item-center.social-icons li a:hover {
        color: #cccccc;
    }

    /* ==== ENLACES FOOTER (como Contáctanos y Categorías) ==== */
    .footer-item-content li {
        list-style: none;
    }

    .footer-item-content li a {
        color: #fff;
        /* Blanco desde el inicio */
        text-decoration: none;
        font-size: 1rem;
        transition: color 0.3s ease;
        display: block;
        padding: 2px 0;
    }

    .footer-item-content li a:hover {
        color: #ccc;
        /* Hover en gris */
        text-decoration: none;
    }

    /* ==== TITULOS DE SECCIONES EN EL FOOTER ==== */
    .footer-link-title h5 {
        font-size: 1.1rem;
        font-weight: bold;
        color: #fff;
        margin-bottom: 10px;
    }

    /* ==== SCROLL PERSONALIZADO SOLO PARA CUADROS DE LINKS ==== */
    .footer-scroll {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .footer-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .footer-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
    }

    .footer-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.7);
    }

    /* ==== RESET DE PADDINGS/MARGINS ==== */
    .footer-box,
    .footer-top-links,
    .bottom-box,
    .footer-item-content,
    .footer-link-title,
    .about-text {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .footer-box {
        padding: 10px 0 !important;
    }
</style>
<style>
    /* Por defecto oculto en mobile */
    .footer-item-content {
        display: none;
    }

    .footer-link-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    /* En pantallas grandes (computadora) se muestra siempre */
    @media (min-width: 992px) {
        .footer-item-content {
            display: block !important;
        }

        .footer-link-icon {
            display: none;
            /* Oculto el icono + en PC */
        }
    }
</style>

<script>
    document.querySelectorAll('.footer-link-title').forEach(title => {
        title.addEventListener('click', () => {
            if (window.innerWidth < 992) { // Solo aplica en móvil/tablet
                let content = title.nextElementSibling;

                // Si el siguiente no es directamente la lista, busca dentro (para Productos)
                if (content && !content.classList.contains('footer-item-content')) {
                    content = content.querySelector('.footer-item-content');
                }

                const icon = title.querySelector('i');

                if (content) {
                    if (content.style.display === "block") {
                        content.style.display = "none";
                        icon.classList.remove("bi-dash-lg");
                        icon.classList.add("bi-plus-lg");
                    } else {
                        content.style.display = "block";
                        icon.classList.remove("bi-plus-lg");
                        icon.classList.add("bi-dash-lg");
                    }
                }
            }
        });
    });
</script>
