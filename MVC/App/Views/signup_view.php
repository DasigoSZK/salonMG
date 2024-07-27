<main class="signup">

  <div id='ressuccess' class='ressuccess d-none'>
    <p class='ressuccess_p'></p>
    <a href="<?=ROOT?>/user/login"><button class='btn btn-primary fw-bold mx-auto mt-3 px-5 py-1 d-block'>ingresar</button></a>
  </div>

  <article class="signup_container">
    <h2 class="signup_title text-light text-center mb-5 display-5 fw-bold">Crea tu cuenta</h2>

    <div id='reserror' class='reserror d-none'>
      <p class='reserror_p'>El correo ingresado ya se encuentra registrado</p>
    </div>

    <form id='signupform' action="" method="POST" class="row custom--form mx-auto">

      <div class="col-12 col-md-6">
        <!-- Nombre -->
        <div class="mb-3 col-12">
          <label for="name" class="form-label text-light mx-auto d-block">Nombre/s*:</label>
          <input name="name" id="nameinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los nombres solo deben incluir letras y espacios en blanco' 
          pattern="^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$">
        </div>

        <!-- Apellido -->
        <div class="mb-3 col-12">
          <label for="lastname" class="form-label text-light mx-auto d-block">Apellido/s*:</label>
          <input name="lastname" id="lastnameinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los apellidos solo deben incluir letras y espacios en blanco' 
          pattern="^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$">
        </div>

        <!-- Teléfono -->
        <div class="mb-3 col-12">
          <label for="phone" class="form-label text-light mx-auto d-block">Teléfono*:</label>
          <input name="phone" id="phoneinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los números de teléfono solo deben incluir números y espacios en blanco' 
          pattern="^[0-9\s]{1,15}$">
        </div>

      </div>

      <!-- Logo -->
      <img class="signupform_img d-none d-md-block col-6" src="<?=ROOT?>/Assets/images/nav-salonLogo.png"
        alt="logo de salon M&G">

      <!-- Correo -->
      <div class="mb-3 col-12">
        <label for="mail" class="form-label text-light mx-auto d-block">Correo Electrónico*:</label>
        <input name="mail" id="mailinput" required type="text" class="form-control custom--input mx-auto"
          title='El correo ingresado no posee un formato válido' 
          pattern="^[a-z0-9]+[a-z0-9.]*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,15}$">
      </div>

      <!-- Contraseña -->
      <div class="mb-3 col-12">
        <label for="pass" class="form-label text-light mx-auto d-block">Contraseña*:</label>
        <input name="pass" id="passinput" required type="password" class="form-control custom--input mx-auto" 
        minlength="8" maxlength="20"
        title='La contraseña debe tener de 8 a 20 caractéres incluyendo letras y números'
        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$">
      </div>
      <div class="mb-3 col-12">
        <label for="pass2" class="form-label text-light mx-auto d-block">Repite contraseña*:</label>
        <input id="pass2input" name='pass2' required type="password" class="form-control custom--input mx-auto" 
        minlength="8" maxlength="20"
        title='Las contraseñas no coinciden'
        pattern="">
      </div>

      <div class="mb-3 col-12">
        <button type="submit" class="btn btn-success fw-bold signupform_btn mx-auto mt-5 d-block">registrarse</button>
      </div>

      
    </form>
  </article>
  <a id='loginLink' href="<?=ROOT?>/user/login"><p class='text-center mt-2 fs-5'>¿Ya estas registrado? <b class='text-primary'>Logueate aquí</b></p></a>

</main>
<script src='<?=ROOT?>/Assets/js/signup.js'></script>