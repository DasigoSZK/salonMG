<main class="useraccount">

  <h1 class='text-center text-white display-1 fw-bold useraccount_h1'>Mi cuenta</h1>

  <section class='row'>
    <article class='col-12 col-lg-4 px-2'>
      <div class='default_card p-3 mt-5 d-flex flex-column align-items-start'>
        <a class='text-primary d-block align-self-end' href="<?=ROOT?>/user/editaccount">Editar</a>
        <h3 class='display-5 fw-bold mb-2'>Mis Datos</h3>
        <p class='fs-6 py-0 my-0'><b>Nombre:</b> <?=$_SESSION['user_name'] ?? ""?> <?=$_SESSION['user_lastname'] ?? "-"?></p>
        <p class='fs-6 py-0 my-0'><b>Teléfono:</b> <?=$_SESSION['user_phone'] ?? "-"?></p>
        <p class='fs-6 py-0 my-0'><b>Correo:</b> <?=$_SESSION['user_mail'] ?? "-"?></p>
      </div>
    </article>
    
    <article class='col-12 col-lg-8 px-2'>
      <div class='default_card p-3 mt-5 d-flex flex-column align-items-start'>
        <h3 class='display-5 fw-bold mb-2'>Mis Compras</h3>

        <!-- Accordions -->
        <div id='accordionContainer' class="accordion purchases-container mx-auto">

          

        </div>
      </div>
    </article>
  </section>

</main>
<script type='module' src='<?=ROOT?>/Assets/js/myAccount.js'></script>