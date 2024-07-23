  <!-- Content -->
  <main class="contact">

    <article class="form_container">

      <h2 class="form_title text-light text-center mb-5 display-2 fw-bold">Escribenos</h2>

      <form action="https://formsubmit.co/greis.ara@hotmail.com" method="POST" class="row custom--form mx-auto">

        <div class="col-12 col-md-6">
          <div class="mb-3 col-12">
            <label for="nombre" class="form-label text-light mx-auto d-block">Nombre Completo*:</label>
            <input name="nombre" required type="text" class="form-control custom--input mx-auto" id="nombre">
          </div>

          <div class="mb-3">
            <label for="telefono" class="form-label text-light mx-auto d-block">Teléfono*:</label>
            <input name="tel" required type="tel" class="form-control custom--input mx-auto" id="telefono">
          </div>
        </div>


        <img class="form_img d-none d-md-block col-6" src="<?=ROOT?>/Assets/images/contact-draw.svg"
          alt="dibujo minimalista de mujer enviando una carta">

        <div class="mb-3 col-12">
          <label for="mensaje" class="form-label text-light mx-auto d-block">Mensaje*:</label>
          <textarea name="mensaje" required type="text" class="custom--textarea form-control custom--input mx-auto"
            id="mensaje"></textarea>
        </div>

        <button type="submit" class="btn btn-light fw-bold custom--btn mx-auto mt-5 d-block">Enviar</button>
      </form>

    </article>

  </main>