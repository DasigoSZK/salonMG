const d = document;

d.addEventListener("DOMContentLoaded", e => {

  deleteLastPurchase();
});

async function deleteLastPurchase() {

  let res = await fetch(`${ROOT}/sales/deleteLastPurchase`);

  let json = await res.json();

  console.log(json)
}