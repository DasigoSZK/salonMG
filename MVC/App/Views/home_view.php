  <!-- Inicio -->
  <main>

    <!-- Hero -->
    <article class="hero">

      <div class="hero_content d-flex flex-column justify-content-center align-items-center h-100 pb-5">

        <h1 class="hero_title text-light text-center pb-5 fw-bold display-1">Salón de Belleza M&G</h1>

        <div class="hero_logos w-100 d-flex justify-content-evenly">

          <div class="hero_logo p-2">
            <a href="#manicurista">
              <img src="<?=ROOT?>/Assets/images/grecia-logo.jpg" alt="logo caricaturizado de la manicurista"
                class="logo_img d-block mx-auto animate__fadeInLeft">
              <h2 class="logo_title text-light display-5 text-center fw-bold mt-2">Manicura</h2>
            </a>
          </div>

          <div class="hero_logo p-2">
            <a href="#peluquera">
              <img src="<?=ROOT?>/Assets/images/marina-logo.jpg" alt="logo caricaturizado de la peluquera"
                class="logo_img d-block mx-auto animate__fadeInRight">
              <h2 class="logo_title text-light display-5 text-center fw-bold mt-2">Peluquería</h2>
            </a>
          </div>

        </div>

      </div>

    </article>

    <!-- Content -->
    <section class="summary">

      <article class="intro p-4 text-center">
        <h3 class="intro_title2 text-center fw-bold text-light p-3">Somos</h3>
        <p class="intro_text text-light ">Una estética administrada por 2 personas, Marina Steyskal y Grecia
          Szkamarda.<br>
          Nos dedicamos principalmente a la manicura, pedicura, peluquería, y a la
          venta
          de
          productos de cosmética
          relacionados.</p>
      </article>

      <hr>

      <article id="manicurista"
        class="mcard d-flex flex-column flex-md-row justify-content-center align-items-center p-5">

        <img id="grecia-sm" src="<?=ROOT?>/Assets/images/grecia-sm.jpg" alt="foto de Grecia Szkamarda (Manicurista)"
          class="mcard_img border border-ligh rounded mb-5">
        <img id="grecia-lg" src="<?=ROOT?>/Assets/images/grecia-lg.jpg" alt="foto de Grecia Szkamarda (Manicurista)"
          class="mcard_img border border-ligh rounded mb-5">

        <div class="mcard_text text-light mx-3">
          <div class="mcard_title mb-2">
            <h3 class="display-2 fw-bold">Hola, soy Grecia Szkamarda</h3>
          </div>
          <p class="fs-4">
            En el salón, me encargo de:<br>
            💅Manicuras<br>
            💅Pedicuras<br>
            💅Uñas esculpidas<br>
            💅Micropigmentación<br>
            💅Microblanding
          </p>
          <a class="fs-3 d-block mt-5" target="_blank"
            href="https://api.whatsapp.com/send/?phone=5493644273506&text&type=phone_number&app_absent=0">
            <i class="bi bi-whatsapp text-success"></i>
            3644-273506
          </a>
        </div>

      </article>

      <hr class="my-5">

      <article id="peluquera"
        class="mcard d-flex flex-column flex-md-row-reverse justify-content-center align-items-center p-5">

        <img id="marina-sm" src="<?=ROOT?>/Assets/images/marina-sm.jpg" alt="foto de Marina Steyskal (Peluquera)"
          class="mcard_img border border-ligh rounded mb-5">
        <img id="marina-lg" src="<?=ROOT?>/Assets/images/marina-lg-cut.jpg" alt="foto de Marina Steyskal (Peluquera)"
          class="mcard_img border border-ligh rounded mb-5">

        <div class="mcard_text text-light mx-3">
          <div class="mcard_title mb-2">
            <h3 class="display-2 fw-bold text-md-end">Hola, soy Marina Steyskal</h3>
          </div>
          <p class="fs-4 text-md-end">
            En el salón, me encargo de:<br>
            Cortes✂️<br>
            Decoloración✂️<br>
            Color + Nutrición✂️<br>
            Alisados✂️
          </p>
          <a class="fs-3 d-block mt-5 text-md-end" target="_blank"
            href="https://api.whatsapp.com/send/?phone=5493644330830&text&type=phone_number&app_absent=0">
            <i class="bi bi-whatsapp text-success"></i>
            3644-330830
          </a>
        </div>

      </article>

    </section>

  </main>