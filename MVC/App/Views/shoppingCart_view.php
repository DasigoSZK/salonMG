  <!-- Contenido -->
  <main class="shoppingCart">

    <h1 class='text-center text-white fs-1 fw-bold useraccount_h1 mx-auto'>Carrito de Compras</h1>

      <!-- Cart -->
      <section class='cart_container mt-4 mx-auto'>

        <!-- EmptyCart(none) -->
        <div id='emptycart' class='my-5 mx-auto d-none'>
          <h4 id='emptycart_h4' class='text-dark text-center fs-1 mb-2'>Tu carrito de compras esta vacío.</h4>
          <p id='emptycart_p' class='text-secondary text-center fs-5 mb-4'>Revisa nuestro catálogo de productos para armar un carrito de compras.</p>
          <a id='emptycart_a' class='emptycart_a' href="<?=ROOT?>/user/market"><button class='btn btn-primary fw-bold mx-auto d-block px-5 py-2'>Ir a Tienda</button></a>
        </div>


      </section>

  </main>
  <script type='module' src='<?=ROOT?>/Assets/js/shoppingCart.js'></script>