<!-- Contenido -->
<main class="successfulPay">

  <div id='paydiv' data-paymentid='<?=$_GET['payment_id']?>' class="successPay default_card mb-5 mx-2 py-3 px-4">
    <h2 class='text-success text-center fs-1 mb-3'>Tu pago fue aprobado✅</h2>
    <p class='text-dark fs-5'>
      Puedes verificar tu compra en la sección "Mis Compras".
      <br><span class='text-secondary'>(Puede tardar unos minutos en procesarse).</span>
    </p>
    <a href="<?=ROOT?>/user/myAccount">
      <button type="submit" class="btn btn-primary fw-bold mx-auto d-block px-5 py-2">Mis Compras</button>
    </a>
  </div>

</main>
<script src='<?=ROOT?>/Assets/js/successfulPay.js'></script>