// -------------------- Function-1 --------------------
export function addToShoppingCart(newProduct) {

  const ls = localStorage;
  // Gets back an existent shoppingCart, or creates a new one if doesn't exist
  let shoppingCart = JSON.parse(ls.getItem("shoppingCart")) || { "productos": [] };

  let flag = false;

  // Check if the product has already been added to the cart
  shoppingCart.productos.forEach(prod => {
    if (prod.prod_id == newProduct.prod_id) {
      prod.prod_quantity += newProduct.prod_quantity;
      flag = true;
    }
  });

  // If the product isn't in the cart
  if (!flag) {
    shoppingCart.productos.push(newProduct);
  }

  // Saves the updated cart in the LS
  ls.setItem("shoppingCart", JSON.stringify(shoppingCart));

  console.log(JSON.parse(ls.getItem("shoppingCart")));
}



// -------------------- Function-2 --------------------
export function updateCartValue($domElement) {

  const ls = localStorage;
  if (ls.getItem("shoppingCart") != null) {
    let shoppingCart = JSON.parse(ls.getItem("shoppingCart"));
    let totalProducts = 0;

    shoppingCart.productos.forEach(prod => {

      totalProducts += prod.prod_quantity;

    });

    $domElement.textContent = totalProducts;
  }


}