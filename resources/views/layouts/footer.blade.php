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
              <div class="about-text footer-item-content">
                <p>
                  <b>En Botica Myryan, creemos que la salud es el tesoro más valioso. Desde nuestros inicios, nos propusimos ofrecer algo más que una simple farmacia: un espacio donde cada persona reciba atención personalizada, orientación confiable y productos de la más alta calidad</b>
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
                    <li><a href="#">Product Category 1</a></li>
                    <li><a href="#">Product Category 2</a></li>
                    <li><a href="#">Product Category 3</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>News</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    <li><a href="#">News Item 1</a></li>
                    <li><a href="#">News Item 2</a></li>
                    <li><a href="#">News Item 3</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>Pages</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    <li><a href="#">Page 1</a></li>
                    <li><a href="#">Page 2</a></li>
                    <li><a href="#">Page 3</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>Specials</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    <li><a href="#">Special Offer 1</a></li>
                    <li><a href="#">Special Offer 2</a></li>
                    <li><a href="#">Special Offer 3</a></li>
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
            <div class="left-links">
              Powered By <a href="https://www.innoshop.com" target="_blank">InnoShop</a>
              <span class="copyright-text">
                <a href="/" class="ms-2" target="_blank">Your Company Name</a>
                &copy; 2025 All Rights Reserved
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

