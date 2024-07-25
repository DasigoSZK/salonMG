<main class="login">

  <article class="login_container">
    <h2 class="login_title text-light text-center mb-5 display-2 fw-bold">Bienvenido a<br>Salón de Belleza M&G</h2>

    <div id='loginerror' class='d-none'>
      <p class='loginerror_p'></p>
    </div>

    <form id='loginform' action="" method="POST" class="row custom--form mx-auto">

      <div class="col-12 col-md-6">
        <div class="mb-3 col-12">
          <label for="mail" class="form-label text-light mx-auto d-block">Correo Electrónico:</label>
          <input name="mail" id="mail" required type="text" class="form-control custom--input mx-auto">
        </div>

        <div class="mb-3">
          <label for="pass" class="form-label text-light mx-auto d-block">Contraseña:</label>
          <input name="pass" id="pass" required type="password" class="form-control custom--input mx-auto">
        </div>
      </div>


      <img class="form_img d-none d-md-block col-6" src="<?=ROOT?>/Assets/images/nav-salonLogo.png"
        alt="logo de salon M&G">

      <div class="mb-3 col-12">
        <input type="checkbox" name="session" id="session">
        <label for="session" class="form-label text-light">Mantener sesión iniciada</label>
      </div>

      <div class="mb-3 col-12">
        <button type="submit" class="btn btn-primary fw-bold custom--btn mx-auto mt-5 d-block">login</button>
      </div>

      
    </form>
  </article>
  <a href=""><p class=''>¿Aún no tienes cuenta? <b class=''>Regístrate aquí</b></p></a>

</main>
<script src='<?=ROOT?>/Assets/js/login.js'></script>

