<?php

require_once 'conectar.php';

// Inserta 1 comentarios
function insertarComentario($tipo='consulta', $titulo, $mensaje, $fk_usuario) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "INSERT INTO comentarios (tipo, titulo, mensaje, fk_usuario) 
                     VALUES ('$tipo', '$titulo', '$mensaje', '$fk_usuario')";

        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion) == 0){

          throw new Exception("Error al insertar el comentario");
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

// Elimina 1 comentarios
function eliminarComentario($id_comentario) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "DELETE FROM comentarios WHERE id_comentario = $id_comentario";
        
        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion) == 0){

          throw new Exception("Error al eliminar el comentario $id_comentario");
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

// Modifica 1 comentarios
function modificarComentario($id_comentario, $tipo='consulta', $titulo, $mensaje, $fk_usuario) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "UPDATE comentarios SET tipo='$tipo', titulo='$titulo', mensaje='$mensaje', fk_usuario='$fk_usuario'
        WHERE id_comentario=$id_comentario";

        mysqli_query($conexion, $consulta);

        if(mysqli_affected_rows($conexion) == 0){

          throw new Exception("Error al modificar el comentario $id_comentario");
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

// Trae 1 comentarios
function traerComentario($id_comentario) {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "SELECT * FROM comentarios WHERE id_comentario=$id_comentario";

        $resultset = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultset) == 0){

          throw new Exception("No se encontró el comentario $id_comentario");
        }

        $registro = mysqli_fetch_assoc($resultset);

        // Cierra la conexión
        mysqli_close($conexion);

        return $registro;
        
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

// Trae TODOS los comentarios
function traerTodosComentarios() {
    try {
        $conexion = conectar();

        if($conexion == null){

          throw new Exception("Error en la conexión: " . mysqli_connect_errno());
        }

        $consulta = "SELECT * FROM comentarios";

        $resultset = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultset) == 0){

          throw new Exception("Error al recuperar los comentarios de la BD.");
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
      // Devuelve null
      return null;
    }
}

?>