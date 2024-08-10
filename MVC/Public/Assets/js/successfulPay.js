const d = document;

d.addEventListener("DOMContentLoaded", e => {

  if (localStorage.getItem("shoppingCart")) {
    localStorage.removeItem("shoppingCart");
  }
  let payment_id = d.querySelector("#paydiv").dataset.paymentid;
  loadPaymentId(payment_id);
});

async function loadPaymentId(payment_id) {

  let obj = {
    "payment_id": payment_id
  };

  let res = await fetch(`${ROOT}/sales/loadPaymentId`, {
    method: 'POST',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify(obj)
  });

}

