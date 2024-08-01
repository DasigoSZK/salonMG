<main class="editaccount">

  <article class="editaccount_container">
    <h2 class="editaccount_title text-light text-center mb-5 display-5 fw-bold">Mi Cuenta</h2>

    <!-- Respuestas del Servidor -->
    <div id='ressuccess' class='ressuccess mb-2 border border-3 border-success d-none'>
      <p class='ressuccess_p fw-bold text-success'></p>
    </div>
    <div id='reserror' class='reserror d-none'>
      <p class='reserror_p'></p>
    </div>

    <form id='editform' action="" method="POST" class="row custom--form mx-auto">

      <div class="col-12 col-md-6">

        <input type="hidden" name="id_user" value="<?=$_SESSION['user_id']?>">

        <!-- Nombre -->
        <div class="mb-3 col-12">
          <label for="name" class="form-label text-light mx-auto d-block">Nombre/s*:</label>
          <input name="name" id="nameinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los nombres solo deben incluir letras y espacios en blanco' 
          pattern="^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$" value='<?=$parameters['user']['nombre']?>'>
        </div>

        <!-- Apellido -->
        <div class="mb-3 col-12">
          <label for="lastname" class="form-label text-light mx-auto d-block">Apellido/s*:</label>
          <input name="lastname" id="lastnameinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los apellidos solo deben incluir letras y espacios en blanco' 
          pattern="^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$" value='<?=$parameters['user']['apellido']?>'>
        </div>

        <!-- Teléfono -->
        <div class="mb-3 col-12">
          <label for="phone" class="form-label text-light mx-auto d-block">Teléfono*:</label>
          <input name="phone" id="phoneinput" required type="text" class="form-control custom--input mx-auto" 
          title='Los números de teléfono solo deben incluir números y espacios en blanco' 
          pattern="^[0-9\s]{1,15}$" value='<?=$parameters['user']['telefono']?>'>
        </div>

      </div>

      <!-- Img -->
      <img class="signupform_img d-none d-md-block col-6" src="<?=ROOT?>/Assets/images/nav-user.svg"
        alt="logo de usuario minimalista">

      <!-- Correo -->
      <div class="mb-3 col-12">
        <label for="mail" class="form-label text-light mx-auto d-block">Correo Electrónico*:</label>
        <input name="mail" id="mailinput" required type="text" class="form-control custom--input mx-auto"
          title='El correo ingresado no posee un formato válido' 
          pattern="^[a-z0-9]+[a-z0-9.]*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,15}$" value='<?=$parameters['user']['correo']?>'>
      </div>

      <!-- Contraseña -->
      <div class="mb-3 col-12">
        <label for="pass" class="form-label text-light mx-auto d-block">Contraseña*:</label>
        <div class='d-flex'>
          <input name="pass" id="passinput" required type="password" class="form-control custom--input mx-auto" 
          minlength="8" maxlength="20"
          title='La contraseña debe tener de 8 a 20 caractéres incluyendo letras y números'
          pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$" placeholder='********' disabled>
          <button type='button' class='editform_editbtn'><img src="<?=ROOT?>/Assets/images/user_edit_btn.svg" alt="lapiz minimalista para editar"></button>
        </div>
      </div>

      <!-- Buttons -->
      <div class='d-flex mt-3 col-12'>
        <div class="mb-3 col-6">
          <button type="submit" class="btn btn-primary fw-bold mx-auto d-block px-5 py-2">Guardar</button>
        </div>
        <div class="mb-3 col-6">
          <a href="<?=ROOT?>/user/myAccount"><button type="button" class="btn btn-secondary fw-bold mx-auto d-block px-5 py-2">Volver</button></a>
        </div>
      </div>

      
    </form>
  </article>

</main>
<script type='module' src='<?=ROOT?>/Assets/js/editAccount.js'></script>