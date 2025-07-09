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
          <div class="col-12 col-md-4 footer-item">
            <div class="about">
              <div class="footer-link-title">
                <span>SOBRE NOSOTROS</span>
                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
              </div>
              <div class="about-text footer-item-content text-white">
                <p>
                  <b>Botica Myryan ofrece atención personalizada, orientación confiable y productos de calidad, priorizando la salud como su mayor valor.</b>
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-8">
            <div class="row">
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>Products</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    <li><a href="#">Medicamentos</a></li>
                    <li><a href="#">Vitaminas</a></li>
                    <li><a href="#">Cuidado Personal</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>Contáctanos</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    <li><a href="#"><i class="bi bi-telephone-fill p-e"></i>973059257</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>Síguenos</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-center social-icons">
                    <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-box">
        <div class="row">
          <div class="col-md-6">
            <div class="left-links">Botica Mirian
              <a href="" target="_blank"></a>. - R.U.C. N° 20608430301
              <span class="copyright-text"> |
                <a href="/" class="ms-2" target="_blank"></a>
                &copy;2025 Botica Mirian Todos los derechos 
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="payment-icon">
              <img src="imagenes/payment/1.png" class="img-fluid" alt="Payment Icon">
              <img src="imagenes/payment/2.png" class="img-fluid" alt="Payment Icon">
              <img src="imagenes/payment/3.png" class="img-fluid" alt="Payment Icon">
              <img src="imagenes/payment/4.png" class="img-fluid" alt="Payment Icon">
              <img src="imagenes/payment/5.png" class="img-fluid" alt="Payment Icon">
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
  .footer-item-center.social-icons {
    display: flex;
    justify-content: flex-start;
    /* alinea a la izquierda, cambia a center si lo prefieres */
    gap: 0px;
    list-style: none;
    padding: 0 0 0 0;
    /* pequeño espacio arriba, sin márgenes */
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

  .footer-item-content li {
  list-style: none;
}

.footer-item-content li a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
  transition: color 0.3s ease;
}

.footer-item-content li a:hover {
  color: #cccccc;
  text-decoration: none;
}

</style>