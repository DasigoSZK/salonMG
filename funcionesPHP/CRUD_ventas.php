<?php

require_once 'conectar.php';

// Registra una venta de 1 SOLO producto
function registrarVenta($id_producto, $cantidad, $id_usuario){

  try {

    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }
    
    //Recuperamos el precio del producto
    $resultset = mysqli_query($conexion, "SELECT precio FROM productos WHERE id_producto=$id_producto");

    if(mysqli_num_rows($resultset) == 0){

      throw new Exception("Producto no encontrado");
    }

    $registro = mysqli_fetch_assoc($resultset);
    $precioProducto = $registro['precio'];

    //Datos de la tabla "ventas"
    $fecha = date("Y-m-d H:i:s", time());
    $monto = $precioProducto * $cantidad;

    // ----------------------- Creamos la venta -----------------------
    $consulta = "INSERT INTO ventas (fecha, monto, fk_usuario) VALUES
                  ('$fecha', $monto, $id_usuario)";

    if(!mysqli_query($conexion, $consulta)){

      throw new Exception("Error al registrar la venta: " . mysqli_error($conexion));
    }

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al insertar la venta (no se afectaron filas)");
    }



    // ----------------------- Creamos registro para producto asociado a la venta -----------------------

    //Recuperamos el ID de la última venta
    $id_venta = mysqli_insert_id($conexion);

    $consulta2 = "INSERT INTO ventas_x_productos (fk_venta, fk_producto, cantidad) VALUES 
                  ($id_venta, $id_producto, $cantidad)";

    if(!mysqli_query($conexion, $consulta2)){

      throw new Exception("Error al registrar los productos asociados a la venta: " . mysqli_error($conexion))
    }

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al insertar el producto asociado a la venta (no se afectaron filas).");
    }

    mysqli_close($conexion);

    return true;
    
  } catch (\Throwable $e) {

    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo "Error al registrar la venta.<br>" . $e->getMessage();
    // Devuelve false
    return false;
    
  }

}

//Registra una venta con MÚLTIPLES PRODUCTOS (carrito)
//Recibe un array por cada producto con ['id_producto', 'cantidad']
function registrarVentaMultiple($id_usuario, array ...$productos){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    //Suma de (precio*cantidad) de cada producto
    $montoTotal = 0;

    // ------------------------ Recuperamos el precio de cada producto ------------------------------------
    foreach($productos as $producto){

      $resultset = mysqli_query($conexion, "SELECT precio FROM productos WHERE id_producto=".$producto[0]);

      if(mysqli_num_rows($resultset) == 0){

        throw new Exception("Producto ".$producto[0]." no encontrado");
      }
      $registro = mysqli_fetch_assoc($resultset);
      $precioProducto = $registro['precio'];
      //Multiplicamos la cantidad * precio para obtener el total de la venta
      $montoTotal += ($producto[1] * $precioProducto);
    }

    $fecha = Date("Y-m-d H:i:s", time());



    // ----------------- Creamos la venta -------------------------
    $consulta = "INSERT INTO ventas (fecha, monto, fk_usuario) VALUES
                  ('$fecha', $montoTotal, $id_usuario)";

    if (!mysqli_query($conexion, $consulta)) {

      throw new Exception("Error al registrar la venta: " . mysqli_error($conexion));
    }

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al registrar la venta");
    }



    // ---------- Creamos registros para CADA producto asociado a la venta ----------

    //Recuperamos el ID de la última venta
    $id_venta = mysqli_insert_id($conexion);

    $consulta2 = "INSERT INTO ventas_x_productos (fk_venta, fk_producto, cantidad) VALUES";

    foreach($productos as $producto){

      $consulta2 .= "($id_venta, ".$producto[0].", ".$producto[1]."),";
    }
    //Borramos la última "," agregada
    $consulta2 = substr($consulta2, 0, -1);

    if (!mysqli_query($conexion, $consulta2)) {

      throw new Exception("Error al registrar los productos asociados a la venta: " . mysqli_error($conexion));
    }

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al registrar los productos asociados a la venta.");
    }

    mysqli_close($conexion);

    return true;

  } catch (\Throwable $e) {
    
    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo "Error al registrar el carrito.<br>" . $e->getMessage();
    // Devuelve false
    return false;

  }

}


// Eliminar una venta (y todos sus registros asociados)
function eliminarVenta($id_venta){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Excpetion("Error en la conexión: " . mysqli_connect_errno());
    }

    // Eliminamos todos los registros de "ventas_x_productos" asociados a la venta
    $consulta = "DELETE FROM ventas_x_productos WHERE fk_venta = $id_venta";
    mysqli_query($conexion, $consulta);

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("No hay productos asociados a la venta $id_venta.");
    }

    // Eliminamos la venta
    $consulta = "DELETE FROM ventas WHERE id_venta = $id_venta";
    mysqli_query($conexion, $consulta);

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("La venta $id_venta no existe.");
    }

    mysqli_close($conexion);

    return true;

  } catch (\Throwable $e) {

    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo $e->getMessage();
    // Devuelve false
    return false;

  }

}

// Traer todas las ventas
function traerVentas(){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Excpetion("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "SELECT * FROM ventas";

    $resultset = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultset) == 0){

      throw new Exception("No hay ventas registradas");
    }

    //Cargamos todas las ventas en un array
    $ventas = array();
    while($registro = mysqli_fetch_assoc($resultset)){

      $ventas[] = $registro;
    }

    mysqli_close($conexion);

    return $ventas;

  } catch (\Throwable $e) {
    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo $e->getMessage();
    // Devuelve false
    return null;
  }
}


// Traer todos los productos asociados a una venta
function traerProductosVenta($id_venta){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Excpetion("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "SELECT * FROM ventas_x_productos WHERE fk_venta=$id_venta";
    $resultset = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultset) == 0){

      throw new Exception("No hay productos asociados a la venta $id_venta");
    }

    $productosCarrito = array();

    while($producto = mysqli_fetch_assoc($resultset)){

      $productosCarrito[] = $producto;

    }

    mysqli_close($conexion);

    return $productosCarrito;

  } catch (\Throwable $e) {
    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo $e->getMessage();
    // Devuelve false
    return null;
  }

}



?>