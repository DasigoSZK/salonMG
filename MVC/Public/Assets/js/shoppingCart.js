// --------------------------------- Variables ---------------------------------
const d = document;
const ls = localStorage;
// EmptyCart 

// ShoppingCart
const $cartContainer = d.querySelector(".cart_container");
const $finalPrice = d.getElementById("finalPrice");


// --------------------------------- Listeners ---------------------------------
d.addEventListener("DOMContentLoaded", e => {

  loadLS();

});

d.addEventListener("click", e => {

  if (e.target.matches(".prod_trash")) {

    let prodID = e.target.dataset.id;

    deleteProdFromLS(prodID);
  }
})







// --------------------------------- Functions ---------------------------------
function loadLS() {

  $cartContainer.innerHTML = `
      <div id='emptycart' class='my-5 mx-auto d-none'>
        <h4 id='emptycart_h4' class='text-dark text-center fs-1 mb-2'>Tu carrito de compras esta vacío.</h4>
        <p id='emptycart_p' class='text-secondary text-center fs-5 mb-4'>Revisa nuestro catálogo de productos para armar un carrito de compras.</p>
        <a id='emptycart_a' class='emptycart_a' href="${ROOT}/user/market"><button class='btn btn-primary fw-bold mx-auto d-block px-5 py-2'>Ir a Tienda</button></a>
      </div>
  `;
  const $emptyCartDiv = d.getElementById("emptycart");
  const $emptyCartH4 = d.getElementById("emptycart_h4");
  const $emptyCartP = d.getElementById("emptycart_p");
  const $emptyCartA = d.getElementById("emptycart_a");

  if (ls.getItem("shoppingCart") != null && JSON.parse(ls.getItem("shoppingCart")).productos.length != 0) {

    $emptyCartDiv.classList.add("d-none");

    let lsProducts = ls.getItem("shoppingCart");

    getShoppingCartProducts(lsProducts);

  } else {

    $emptyCartDiv.classList.remove("d-none");

  }
}

async function getShoppingCartProducts(lsProducts) {

  console.log(lsProducts);

  let res = await fetch(`${ROOT}/product/loadShoppingCart`, {
    method: 'POST',
    headers: {
      'Content-type': 'application/json'
    },
    body: lsProducts
  });

  let json = await res.json();

  console.log(json);

  if (json.success) {

    let productsData = json.result;
    loadShoppingCart(productsData);

  } else {

    $emptyCartH4.textContent = "Ocurrió un error al cargar su carrito.";
    $emptyCartH4.classList.add("text-danger");
    $emptyCartP.textContent = "Lamentamos los incovenientes, vuelva a intentarlo mas tarde.";
    $emptyCartA.classList.add("d-none");
  }

}

async function loadShoppingCart(products) {

  let $fragment = d.createDocumentFragment();
  let finalPrice = 0;

  products.forEach(prod => {

    // <article>
    let $cartProd = d.createElement("article");
    $cartProd.className = "cart_prod row px-4  mb-3";

    // Img / Title / Quantity
    $cartProd.innerHTML = `
      <div class='col-8 d-flex justify-content-start align-items-center'>
        <img src="${ROOT}/Assets/images/${prod.prod_photo}" alt="${prod.prod_name}" class="prod_img">
        <div class='d-flex flex-column ms-2 align-self-start'>
          <h5 class='prod_title fs-5'>${prod.prod_name}</h5>
          <div class='prod_quantitybtn mt-2'>
            <span id='minusbtn' class="quantity_minus text-primary fw-bold">-</span>
            <input id="quantity_input" type="number" name="quantity" value='${prod.prod_quantity}' min='1' max='${prod.prod_stock}' step='1' >
            <span id='plusbtn' class="quantity_plus text-primary fw-bold">+</span>
          </div>
        </div>
      </div>
      <!-- Trash/Price -->
      <div class='col-4 d-flex flex-column align-items-end justify-content-between'>
        <img data-id='${prod.prod_id}' src="${ROOT}/Assets/images/trash_icon.svg" alt="minimalist trash icon" class="prod_trash">
        <p id='price${prod.prod_id}' class="prod_price mb-0 fs-5 text-success opacity-75">$${prod.prod_price * prod.prod_quantity}</p>
      </div>
    `;

    // hr
    let $prodHr = d.createElement("hr");
    $prodHr.className = "cart_hr fw-bold border border-1 border-secondary text-secondary mx-3";

    $fragment.appendChild($cartProd);
    $fragment.appendChild($prodHr);

    finalPrice += (prod.prod_price * prod.prod_quantity);

  });

  // Final Price
  let $finalPrice = d.createElement("div");
  $finalPrice.id = "finalPrice";
  $finalPrice.className = "d-flex justify-content-between align-items-end px-3 mt-4";
  $finalPrice.innerHTML = `
    <h3 class='fs-3 text-black fw-bold me-3'>Precio Final:</h3>
    <p class='fs-3 text-success fw-bold p-0 m-0'>$${finalPrice}</p>
  `;

  $fragment.appendChild($finalPrice);

  $cartContainer.appendChild($fragment);


}

function deleteProdFromLS(prodID) {

  let shoppingCart = JSON.parse(ls.getItem("shoppingCart"));

  for (let i = 0; i < shoppingCart.productos.length; i++) {

    if (shoppingCart.productos[i].prod_id == prodID) {
      shoppingCart.productos.splice(i, 1);
      break;
    }
  }

  ls.setItem("shoppingCart", JSON.stringify(shoppingCart));

  loadLS();
}