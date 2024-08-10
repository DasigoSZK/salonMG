<!-- Contenido -->
<main class="successfulPay">

  <div class="successPay default_card mx-2 py-3 px-4">
    <h2 class='text-danger text-center fs-1 mb-3'>Ocurrió un error en la compra⛔</h2>
    <p class='text-dark fs-5'>
      No se aplicó ningún cargo a tu tarjeta.
      <br><span class='text-secondary'>Puedes volver a intentarlo mas tarde u con otro método de pago.</span>
    </p>
    <a href="<?=ROOT?>/user/market">
      <button type="submit" class="btn btn-primary fw-bold mx-auto d-block px-5 py-2">Ir a Tienda</button>
    </a>
  </div>

</main>
<script src='<?=ROOT?>/Assets/js/failedPayment.js'></script>