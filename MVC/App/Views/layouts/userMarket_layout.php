<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?=ROOT?>/Assets/images/favicon.png" type="image/x-icon">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?=ROOT?>/Assets/css/styles.css">
  <script>
    //Guarda la variable de PHP con el URL del directorio
    var ROOT = '<?= ROOT ?>';
  </script>
  <title>Salón de Belleza M&G</title>
</head>

<body>
  
  <!-- NavBar -->
  <nav class="navbar--color navbar sticky-top  bg-body-tertiary">

    <div class="d-lg-block w-100">

      <div class="nav_menu mx-auto d-flex justify-content-between align-items-center">

        <a class="navbar-brand" href="<?=ROOT?>/user/home"><img class="nav_logo" src="<?=ROOT?>/Assets/images/nav-salonLogo.png"
            alt="logo de SalonDeBellezaMG"></a>

        <form id='searchForm' class="d-flex w-75" role="search">
          <input name='search' class="form-control me-2" type="search" placeholder="Busca un producto..." aria-label="Search">
          <button class="btn btn-outline-light" type="submit">
            <svg class="navbar_search text-light" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
              fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path
                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
          </button>
        </form>

        <div class="navbar_buttons justify-self-end min-width-120">

          <a href="<?=ROOT?>/user/error"><img src="<?=ROOT?>/Assets/images/nav-carrito.svg" class="nav_carrito" alt="carrito de compras"></a>
          <button class="navbar-toggler fs-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>


      </div>

      <hr class="d-none d-lg-block nav_hr">

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav w-100 d-flex flex-lg-row-reverse justify-content-evenly">

          <li class="nav-item p-2">
            <a class="nav-link active text-light fw-bold text-end" aria-current="page" href="<?=$parameters['href'] ?? ROOT.'/user/login'?>">
              <?= $parameters['title'] ?? "Iniciar Sesión"?>
              <img src="<?=ROOT?>/Assets/images/nav-user.svg" class="nav_icon" alt="logo minimalista de usuario">
            </a>
          </li>

          <li class="nav-item p-2">
            <a class="nav-link active text-light fw-bold text-end" aria-current="page" href="<?=ROOT?>/user/market">
              Tienda
              <img src="<?=ROOT?>/Assets/images/nav-tienda.svg" class="nav_icon" alt="logo minimalista de tienda">
            </a>
          </li>

          <li class="nav-item p-2">
            <a class="nav-link text-light fw-bold text-end" href="<?=ROOT?>/user/aboutus">
              Sobre Nosotras
              <img src="<?=ROOT?>/Assets/images/nav-nosotras.svg" class="nav_icon" alt="logo minimalista de personas">
            </a>
          </li>

          <li class="nav-item p-2">
            <a class="nav-link text-light fw-bold text-end" href="<?=ROOT?>/user/faqs">
              Preguntas Frecuentes
              <img src="<?=ROOT?>/Assets/images/nav-preguntas.svg" class="nav_icon" alt="logo minimalista de signo de interrogación">
            </a>
          </li>

          <li class="nav-item p-2">
            <a class="nav-link text-light fw-bold text-end" href="<?=ROOT?>/user/contact">
              Contacto
              <img src="<?=ROOT?>/Assets/images/nav-contacto.svg" class="nav_icon" alt="logo minimalista de mail">
            </a>
          </li>

        </ul>

      </div>
    </div>
  </nav>

  <!-- VIEW content -->
  <?= $content ?>

  <!-- Footer -->
  <footer class="row">

    <div class="footer_div p-4 col-12 col-lg-4">

      <div class="d-flex flex-column align-items-center">
        <h3 class="div_titulo fw-bold h3 mb-4">CONTÁCTANOS:</h3>
        <div class="div_links">
          <div class="footer_link">
            <a href="tel:+543644273506"><img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-telefono.svg"
                alt="ícono minimalista de teléfono"><span>Manicuras:
                3644-273506</span></a>
          </div>

          <div class="footer_link">
            <a href="tel:+543644330830"><img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-telefono.svg"
                alt="ícono minimalista de teléfono"><span>Pedicuras:
                3644-330830</span></a>
          </div>

          <div class="footer_link">
            <a target="_blank"
              href="https://www.google.com/maps/place/26%C2%B048'14.0%22S+60%C2%B024'57.7%22W/@-26.8038981,-60.4182115,17z/data=!3m1!4b1!4m4!3m3!8m2!3d-26.8038981!4d-60.4160228?hl=es">
              <img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-locacion.svg"
                alt="ícono minimalista de ubicación geográfica">
              <span>Av 301. (Papa
                Francisco) entre Paraísos y Guayacanes</span></a>
          </div>

        </div>
      </div>

    </div>

    <div class="footer_div p-4 col-12 col-lg-4">

      <div class="d-flex flex-column align-items-center">
        <h3 class="div_titulo fw-bold h3 mb-4">MEDIOS DE PAGO:</h3>
        <div class="div_links">

          <div class="footer_link">
            <img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-efectivo.svg" alt="ícono minimalista de un billete">
            <span>Efectivo</span>
          </div>

          <div class="footer_link">
            <img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-tarjeta.svg"
              alt="ícono minimalista de tarjeta de crédito">
            <span>Tarjeta de crédito/débito</span>
          </div>

          <div class="footer_link col-12">
            <img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-billetera.svg" alt="ícono minimalista de billetera">
            <span>MercadoPago</span>
          </div>

          <div class="footer_link">
            <img class="footer_icon" src="<?=ROOT?>/Assets/images/footer-banco.svg" alt="ícono minimalista de banco">
            <span>Transferencia Bancaria</span>
          </div>
        </div>


      </div>
    </div>

    <div class="footer_div p-4 col-12 col-lg-4">

      <div class="d-flex flex-column align-items-center">
        <h3 class="div_titulo fw-bold h3 mb-4">REDES:</h3>
        <div class="div_links">

          <a target="_blank" href="https://www.facebook.com/nails.greecee">
            <img src="<?=ROOT?>/Assets/images/footer-fb.svg" alt="ícono minimalista de Facebook (red social)" class="footer_redes">
          </a>

          <a target="_blank"
            href="https://api.whatsapp.com/send/?phone=5493644273506&text&type=phone_number&app_absent=0">
            <img src="<?=ROOT?>/Assets/images/footer-wpp.svg" alt="ícono minimalista de WhatsApp" class="footer_redes">
          </a>

          <a target="_blank" href="https://www.instagram.com/salon.de.belleza.mg/">
            <img src="<?=ROOT?>/Assets/images/footer-ig.svg" alt="ícono minimalista de Instagram (red social)"
              class="footer_redes">
          </a>
        </div>

      </div>
    </div>
  </footer>

  <!-- Boostrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src='<?=ROOT?>/Assets/js/market.js'></script>
</body>

</html>