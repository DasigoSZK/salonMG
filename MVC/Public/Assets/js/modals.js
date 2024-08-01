// Modales Genéricas
export const BsModal = {
  confirm({
    title = '',                         //Título
    content = '',                       //Descripción
    type = 'primary',                   //Color del ícono y el botón
    confirm = 'true',                   //Muestra, o no, el botón de cancelar
    icon = 'fa-solid fa-circle-info',   //Icono del modal
    okBtnText = 'Confirmar',            //Texto del botón de confirmar
    cancelBtnText = 'Cancelar',         //Texto del botón de cancelar
    onOk = () => { },                   //Función del botón confirmar
    onCancel = () => { }                //Función del botón cancelar
  }) {

    //Contenedor del modal
    const $modal = document.createElement("div");
    //ID unico para cada Modal
    let uniqueModalID = document.querySelectorAll(".modal").length + 1;
    //Botón cancelar
    const $cancelBtn = confirm ? `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cancel_btn${uniqueModalID}'>${cancelBtnText}</button>` : "";

    $modal.innerHTML = `
    <div class="modal fade" id="exampleModal${uniqueModalID}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body text-center">
          <div class='h1 text-${type}'><i class="${icon}"></i></div>
          <h1 class="modal-title fs-5" id="exampleModalLabel">${title}</h1>
            <div>${content}</div>
            <div class='mt-4'>
              <button type="button" class="btn btn-${type}" id='confirm_btn${uniqueModalID}'>${okBtnText}</button>
              ${$cancelBtn}
            </div>
          </div>
        </div>
      </div>
    </div>
    `;


    //Añadimos el Modal al DOM
    document.body.appendChild($modal);

    const $divModal = document.getElementById(`exampleModal${uniqueModalID}`);
    const myModal = new bootstrap.Modal($divModal);
    myModal.show();

    // Eventos de los botones
    let $btn1 = document.getElementById(`confirm_btn${uniqueModalID}`);
    let $btn2 = document.getElementById(`cancel_btn${uniqueModalID}`);

    // ---------- OK btn ----------
    $btn1.addEventListener("click", e => {

      e.preventDefault();
      e.stopPropagation();
      //Llamamos a la función de los parámetros
      onOk();
      //Ocultamos y eliminamos la modal
      myModal.hide();
      $divModal.remove();
    })

    // ---------- CANCEL btn ----------
    $btn2.addEventListener("click", e => {

      e.preventDefault();
      e.stopPropagation();
      //Llamamos a la función de los parámetros
      onCancel();
      //Ocultamos y eliminamos la modal
      myModal.hide();
      $divModal.remove();
    })
  },
  //2do método (llama a confirm pero con parámetros SUCCESSS)
  success(params) {

    this.confirm({
      icon: 'fa-solid fa-check',
      type: 'success',
      confirm: false,
      okBtnText: 'Aceptar',
      ...params
    })
  },
  //3er método (llama a confirm pero con parámetros WARNING)
  warning(params) {

    this.confirm({
      icon: "fa-solid fa-triangle-exclamation",
      type: 'warning',
      confirm: false,
      okBtnText: 'Aceptar',
      ...params
    })
  },
  //4to método (llama a confirm pero con parámetros DANGER)
  danger(params) {

    this.confirm({
      icon: "fa-solid fa-bug",
      type: 'danger',
      confirm: false,
      okBtnText: 'Aceptar',
      ...params
    })
  },
  promt({
    title = '',                         //Título
    content = '',                       //Descripción
    type = 'primary',                   //Color del ícono y el botón
    inputType = 'text',                 //Modifica el tipo de input que rellena
    confirm = 'true',                   //Muestra, o no, el botón de cancelar
    okBtnText = 'Confirmar',            //Texto del botón de confirmar
    cancelBtnText = 'Cancelar',         //Texto del botón de cancelar
    onOk = () => { },                   //Función del botón confirmar
    onCancel = () => { }                //Función del botón cancelar
  }) {

    //Contenedor del modal
    const $modal = document.createElement("div");
    //ID unico para cada Modal
    let uniqueModalID = document.querySelectorAll(".modal").length + 1;
    //Botón cancelar
    const $cancelBtn = confirm ? `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cancel_btn${uniqueModalID}'>${cancelBtnText}</button>` : "";

    $modal.innerHTML = `
    <div class="modal fade" id="exampleModal${uniqueModalID}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body text-center">
          <h1 class="modal-title fs-5" id="exampleModalLabel">${title}</h1>
            <div>${content}</div>
            <input id='modal_input' type='${inputType}' >
            <div class='mt-4'>
              <button type="button" class="btn btn-${type}" id='confirm_btn${uniqueModalID}'>${okBtnText}</button>
              ${$cancelBtn}
            </div>
          </div>
        </div>
      </div>
    </div>
    `;


    //Añadimos el Modal al DOM
    document.body.appendChild($modal);

    const $divModal = document.getElementById(`exampleModal${uniqueModalID}`);
    const myModal = new bootstrap.Modal($divModal);
    myModal.show();

    // Eventos de los botones
    let $btn1 = document.getElementById(`confirm_btn${uniqueModalID}`);
    let $btn2 = document.getElementById(`cancel_btn${uniqueModalID}`);

    // ---------- OK btn ----------
    $btn1.addEventListener("click", e => {

      e.preventDefault();
      e.stopPropagation();
      //Llamamos a la función de los parámetros
      onOk();
      //Ocultamos y eliminamos la modal
      myModal.hide();
      $divModal.remove();
    })

    // ---------- CANCEL btn ----------
    $btn2.addEventListener("click", e => {

      e.preventDefault();
      e.stopPropagation();
      //Llamamos a la función de los parámetros
      onCancel();
      //Ocultamos y eliminamos la modal
      myModal.hide();
      $divModal.remove();
    })
  }
}
