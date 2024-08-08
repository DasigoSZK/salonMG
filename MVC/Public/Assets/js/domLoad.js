import { updateCartValue } from "./addToShoppingCart.js";

const d = document;

d.addEventListener("DOMContentLoaded", e => {

  updateCartValue(d.querySelector(".cartSpan"));
})