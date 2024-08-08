import { formatDate } from './formatDatetime.js';

const d = document;
const $accordionContainer = d.getElementById("accordionContainer");

d.addEventListener("DOMContentLoaded", e => {

  getPurchases();
})

async function getPurchases() {

  let res = await fetch(`${ROOT}/sales/userPurchases`);
  let json = await res.json();

  if (json.success) {
    let userPurchases = json.result;

    let $accordionsFragment = d.createDocumentFragment();

    // Each Purchase
    userPurchases.forEach((purchase) => {

      // Purchase Header
      let $accordion = d.createElement("div");
      $accordion.classList.add("accordion-item", "purchases-accordion-body", "my-3");

      let formatedDate = formatDate(purchase.fecha);
      let state = purchase.confirmado
        ? "<span class='text-success fw-bold'>Confirmado</span>"
        : "<span class='text-danger fw-bold'>Confirmación Pendiente</span>";

      $accordion.innerHTML = `
            <h2 class="accordion-header">
              <button class="accordion-button purchases-accordion_header collapsed text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapse${purchase.id_venta}" aria-expanded="false"
                aria-controls="panelsStayOpen-collapse${purchase.id_venta}">
                <div class='d-flex flex-column flex-lg-row justify-content-between w-100'>
                  <div>
                    <b>Compra N°${purchase.id_venta}: </b> <span class='accordionpurchase-date ml-5'>${formatedDate}</span>
                  </div>
                  <div class='me-5 fs-6'>
                    <b>Pago: </b>${state}
                  </div>
                </div>
              </button>
            </h2>
            <div id="panelsStayOpen-collapse${purchase.id_venta}" class="accordion-collapse collapse">
              <article class="accordion-body"></article>
            </div>
        `;

      let $accordionBody = $accordion.querySelector('.accordion-body');

      // Each items of the accordion
      purchase.productos.forEach((prod) => {
        let $productItem = d.createElement("div");
        $productItem.classList.add("shoppeditem", "d-flex", "justify-content-between", "align-items-center", "mt-2", "mb-3");

        $productItem.innerHTML = `
                <div class='d-flex align-items-start w-50'>
                  <img class='purchase_img' src="${ROOT}/Assets/images/${prod.foto}" alt="Foto de ${prod.nombre}">
                  <div>
                    <h4 class='ms-2 mt-2 fs-6'>${prod.nombre}</h4>
                    <h6 class='ms-2 mt-1 fs-6 text-secondary'>${prod.cantidad_comprada} unidad/es</h6>
                  </div>
                </div>
                <h3 class='fs-5 opacity-75 text-success'>$${prod.precio}</h3>
            `;

        $accordionBody.appendChild($productItem);

        let $hr = d.createElement("hr");
        $hr.classList.add('opacity-100', 'border', 'border-1', 'border-secondary', 'text-secondary', 'mx-3');
        $accordionBody.appendChild($hr);
      });

      // Final price
      let $total = d.createElement("h2");
      $total.classList.add('d-flex', 'justify-content-between', 'mt-2');

      $total.innerHTML = `
            <span class='total_text fs-4'>Total</span>
            <span class='total_price fs-4 text-success'>$${purchase.monto_total}</span>
        `;

      $accordionBody.appendChild($total);

      $accordionsFragment.appendChild($accordion);
    });

    $accordionContainer.appendChild($accordionsFragment);

  } else {

    let $resH3 = d.createElement("h3");
    $resH3.textContent = json.message;
    $resH3.className = "fs-4 text-secondary my-2";
    $accordionContainer.appendChild($resH3);
  }
}