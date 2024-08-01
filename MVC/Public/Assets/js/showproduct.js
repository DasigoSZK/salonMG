const d = document;
const $unitsInput = d.getElementById("product_units");

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
  }

})