const d = document;
const $sectionCards = d.getElementById("productcards");

//#region PAGINATION

// 1

//Load
d.addEventListener("DOMContentLoaded", (e) => {

  loadMarketProducts();
})

//Search
d.addEventListener("submit", (e) => {
  if (e.target.matches("#searchForm")) {

    e.preventDefault();
    $sectionCards.innerHTML = "";
    //Loads the search
    let search = e.target.search.value;
    loadMarketProducts(search);
  }
})

// 2
async function loadMarketProducts(search = "") {

  //Page requested
  let url = new URL(window.location.href);
  let params = new URLSearchParams(url.search);
  let page = params.get('page');
  if (!page || search != "") {
    page = 1;
    if (params.has('page')) params.set('page', 1);
  }

  //Search
  let searchParam = "";
  let urlSearch = params.has('search') ? params.get('search') : "";
  if (search != "" || urlSearch != "") {
    if (search != "") {
      searchParam = `&search=${search}`;
    } else {
      searchParam = `&search=${urlSearch}`;
    }
  }

  //Fetch products
  let res = await fetch(`${ROOT}/product/marketProducts?page=${page}${searchParam}`);
  let json = await res.json();



  if (json.success) {
    let products = json.result.data;
    let page = json.result.page;
    let pages = json.result.pages;

    insertProducts(products, page, pages, $sectionCards, searchParam);

  } else {

    let $error = d.createElement("h3");
    $error.textContent = "Ups... Ocurrió un error al recuperar los productos";
    $sectionCards.appendChild($error);

  }
}

// 3
function insertProducts(products, page, pages, $domElement, searchParam = "") {

  // ----------------------------------------------- Products ------------------------------------------------------
  $fragment = d.createDocumentFragment();

  if (products.length != 0) {
    products.forEach((prod) => {

      //CARD
      let tempDiv = d.createElement("div");
      tempDiv.className = "card bg-transparent border-0 mb-5 mx-auto col-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3";
      tempDiv.innerHTML = `
        <a href='${ROOT}/product/showProduct?product=${prod.id_producto}'>
          <img src="${ROOT}/Assets/images/${prod.foto}" class="card-img-top" alt="4 botellas del kit de higiene facial">
        </a>
        <div class="card-body">
          <a href='${ROOT}/product/showProduct?product=${prod.id_producto}'>
            <h5 class="card-title text-white fs-4 text-start">${prod.nombre_producto}</h5>
          </a>
          <p class="card-text card_price text-white text-start fs-2">
            $${prod.precio}
          </p>
          <div class="d-flex flex-column flex-lg-row justify-content-between">
            <a href="${ROOT}/user/error" data-id='${prod.id_producto}' class="btn btn-shop btn-buy ms-auto me-2">
              Comprar <img class='d-inline mp-icon' src='${ROOT}/Assets/images/mercadopago_icon.svg'>
            </a>
            <a href="${ROOT}/user/error" data-id='${prod.id_producto}' class="btn btn-shop btn-shop--cart mx-auto"><i class="bi bi-cart"></i></a>
          </div>
        </div>
    `;

      $fragment.appendChild(tempDiv);
    })
  } else {

    let $error = d.createElement("p");
    $error.classList.add("search_error");
    $error.innerHTML = `No se encontraron resultados...`;
    $fragment.appendChild($error);
  }



  //Insert into DOM
  $domElement.appendChild($fragment);



  // ----------------- Pagination LINKS ---------------------
  $pages = d.createElement("div");
  $pages.classList.add("pages");

  $pagesText = d.createElement("p");
  $pagesText.classList.add("pagination_text");
  $pagesText.textContent = "Páginas:";

  $linkContainer = d.createElement("div");
  $linkContainer.className = 'pagination';

  $pages.appendChild($pagesText);

  for (let i = 1; i <= pages; i++) {
    //<a>
    $link = d.createElement("a");
    $link.href = `${ROOT}/user/market?page=${i}${searchParam}`;
    $link.classList.add("page_link");
    //<button>
    $linkBtn = d.createElement("button");
    $linkBtn.textContent = i;
    $linkBtn.type = "button";
    $linkBtn.className = "pagination_btn";
    //.active
    if (i == page) $link.classList.add("active");
    if (i == page) $linkBtn.classList.add("active");

    $link.appendChild($linkBtn);
    $linkContainer.appendChild($link);
  }

  $pages.appendChild($linkContainer);

  //Insert into DOM
  $domElement.appendChild($pages);

}
//#endregion








