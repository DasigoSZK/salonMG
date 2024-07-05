<?php

require_once 'conectar.php';

// Inserta 1 producto
function insertarProducto($nombre_producto, $precio, $stock, $descripcion = '', $foto = 'image_notfound.png') {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "INSERT INTO productos (nombre_producto, precio, stock, descripcion, foto) 
                     VALUES ('$nombre_producto', '$precio', '$stock', '$descripcion', '$foto')";

        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion) == 0){

          throw new Exception("Error al insertar el producto '$nombre_producto'");
        }
        
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

// Elimina 1 producto
function eliminarProducto($id_producto) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "DELETE FROM productos WHERE id_producto = $id_producto";
        
        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion) == 0){

          throw new Exception("Error al eliminar el producto $id_producto");
        }

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

// Modifica 1 producto
function modificarProducto($id_producto, $nombre_producto, $precio, $stock, $descripcion = '', $foto = 'image_notfound.png') {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "UPDATE productos SET nombre_producto='$nombre_producto', precio='$precio', stock='$stock', descripcion='$descripcion', foto='$foto' WHERE id_producto=$id_producto";

        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion)){

          throw new Exception("Error al modificar el producto $id_producto - $nombre_producto");
        }

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

// Trae 1 producto
function traerProducto($id_producto) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "SELECT * FROM productos WHERE id_producto=$id_producto";

        $resultset = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultset) == 0){

          throw new Exception("No se encontró el producto $id_producto");
        }

        $registro = mysqli_fetch_assoc($resultset);

        // Cierra la conexión
        mysqli_close($conexion);

        return true;
        
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

// Trae TODOS los productos
function traerTodosProductos() {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "SELECT * FROM productos";

        $resultset = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultset) == 0){

          throw new Exception("Error al recuperar los productos de la BD.");
        }

        $arrayRegistros = array();

        while ($registro = mysqli_fetch_assoc($resultset)) {
            $arrayRegistros[] = $registro;
        }

        // Cierra la conexión
        mysqli_close($conexion);

        return $arrayRegistros;
        
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
