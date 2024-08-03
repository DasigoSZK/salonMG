<main class="showproduct">

  
  <section class='row justify-content-center'>
    
    <!-- Producto image  -->
    <img class='col-12 col-lg-3 showproduct_img' src="<?=ROOT?>/Assets/images/<?=$parameters['product']['foto'] ?? "image_notfound.png"?>" alt="<?=$parameters['product']['nombre_producto']?>">

    <!-- Title / Price / Buttons / Description -->
    <section class='col-12 col-lg-5'>

      <!-- Title and Price -->
      <article class=''>
        <h1 class='text-white fw-bold display-5'><?=$parameters['product']['nombre_producto']?></h1>
        <h3 class='showproduct_price display-6 text-start mt-2 mb-3'>$<?=$parameters['product']['precio']?></h3>
      </article>

      <!-- Purchase buttons -->
      <article class=''>

        <div class='d-flex align-items-center justify-content-evenly'>
          <div class='d-flex align-items-center justify-content-start'>
            <div class='showproduct_stockbtn'>
              <span id='minus' class='stockbtn_signs'><b>-</b></span>
              <input class='fs-5' type="number" name="units" id="product_units" value='1' step='1' min='1' max='<?=$parameters['product']['stock']?>'>
              <span id='plus' class='stockbtn_signs'><b>+</b></span>
            </div>
            <span class='text-secondary fs-5'>(<?=$parameters['product']['stock']?> disponibles)</span>
          </div>
        </div>

        <div class='d-flex justify-content-center'>
          <div class='d-flex flex-column align-items-start w-100'>
            <a class='showproduct_btn_a mx-auto' href=""><button class='btn showproduct_btn mt-4 mb-2'>
              Comprar ahora <img class='d-inline mp-icon' src='<?=ROOT?>/Assets/images/mercadopago_icon.svg'></button></a>
            <a class='showproduct_btn_a mx-auto' href=""><button class='btn showproduct_btn showproduct_btn--secondary'>Agregar al carrito</button></a>
          </div>
        </div>

      </article>

      

    </section>

    <hr class='showproduct_hr'>

    <!-- Description -->
    <article class='showproduct_description mx-auto col-12 pb-5'>

      <h2 class='text-start text-white fw-bold display-5'>Descripción</h2>
      <p class='mt-3 text-white fs-6'><?=$parameters['product']['descripcion'] ?? "No hay descripción para este producto."?></p>

    </article>
    

  </section>

</main>
<script src='<?=ROOT?>/Assets/js/showproduct.js'></script>