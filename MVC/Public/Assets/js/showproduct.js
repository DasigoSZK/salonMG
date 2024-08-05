const d = document;
const $unitsInput = d.getElementById("product_units");


// ---- Loads MP Preference ----
d.addEventListener("DOMContentLoaded", e => {

  loadMercadoPagoBtn();
});


// ---- Product units btn ----
d.addEventListener("click", e => {

  // Product Units buttons
  if (e.target.matches("#plus") || e.target.matches("#minus") || e.target.matches("#plus *") || e.target.matches("#minus *")) {

    if (e.target.matches("#plus *") || e.target.matches("#plus")) {
      if ($unitsInput.value == $unitsInput.max) return;
      $unitsInput.value = parseInt($unitsInput.value) + 1
    }
    if (e.target.matches("#minus *") || e.target.matches("#minus")) {
      if ($unitsInput.value == $unitsInput.min) return;
      $unitsInput.value = parseInt($unitsInput.value) - 1;
    }

    // Loads a new buy btn
    prod_quantity = $unitsInput.value;
    loadMercadoPagoBtn();
  }

})

d.addEventListener("change", e => {
  if (e.target.matches("#product_units")) {
    // Loads a new buy btn
    prod_quantity = $unitsInput.value;
    loadMercadoPagoBtn();
  }
})

// Loads the preferences for the MP payment
async function loadMercadoPagoBtn() {

  const formData = new FormData();
  formData.append('prod_id', prod_id);
  formData.append('prod_name', prod_name);
  formData.append('prod_price', prod_price);
  formData.append('prod_description', prod_description);
  formData.append('prod_photo', prod_photo);
  formData.append('user_name', user_name);
  formData.append('user_lastname', user_lastname);
  formData.append('user_email', user_email);
  formData.append('prod_quantity', prod_quantity);

  let res = await fetch(`${ROOT}/product/createMPPreference`, {
    method: 'POST',
    body: formData
  });

  let json = await res.json();

  if (json.success) {

    // Removes the last btn
    let $parentContainer = d.getElementById("btn_container");
    let $newBtn = d.createElement("div");
    $newBtn.id = "wallet_container";
    $newBtn.className = "mx-auto showproduct_btn_a";
    let $mercadoPagoBtn = d.getElementById("wallet_container");
    $parentContainer.replaceChild($newBtn, $mercadoPagoBtn);

    // TOKEN AND CURRENCY
    const mp = new MercadoPago(`${MP_PUBLIC_KEY}`, {
      locale: 'es-AR'
    });

    // BTN CONFIG
    mp.bricks().create("wallet", "wallet_container", {
      initialization: {
        // Prod IDs
        preferenceId: json.result,
        // Redirection type
        redirectMode: "self"
      },
      // BTN Customization
      customization: {
        texts: {
          // (pay=pagar, buy=comprar)
          action: "buy",
          // (security_safety="Pagar de forma segura")
          valueProp: "security_safety"
        }
      }
    });
  }
}