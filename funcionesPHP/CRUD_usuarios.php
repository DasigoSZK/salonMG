<?php

require_once 'conectar.php';


// Inserta 1 usuario
function insertarUsuario($nombre, $apellido, $telefono, $correo, $contrasena, $fk_tipo_usuario){

  try{

    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "INSERT INTO usuarios VALUES 
                (0, '$nombre', '$apellido', '$telefono', '$correo', '$contrasena', '$fk_tipo_usuario')";

    mysqli_query($conexion, $consulta);

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al insertar el usuario.");
    }
    
    return true;

  }catch(\Throwable $e){

    // Cierra la conexión si esta abierta
    if (isset($conexion) && mysqli_connect_errno() === 0) {
      mysqli_close($conexion);
    }
    echo $e->getMessage();
    // Devuelve false
    return false;

  }



}

// Elimina 1 usuario
function eliminarUsuario($usuario_id){

  try {

    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario = $usuario_id";
    
    mysqli_query($conexion, $consulta);

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al eliminar el usuario $usuario_id");
    }

    // Devuelve el error
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

// Modifica 1 usuario
function modificarUsuario($id_usuario, $nombre, $apellido, $telefono, $correo, $contrasena, $fk_tipo_usuario){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', telefono='$telefono', correo='$correo', contrasena='$contrasena', fk_tipo_usuario='$fk_tipo_usuario' WHERE id_usuario=$id_usuario";

    mysqli_query($conexion, $consulta);

    if(mysqli_affected_rows($conexion) == 0){

      throw new Exception("Error al modificar el usuario $id_usuario");
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

// Trae 1 usuario
function traerUsuario($id_usuario){

  try {

    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "SELECT * FROM usuarios WHERE id_usuario=$id_usuario";

    $resultset = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultset) == 0){

      throw new Exception("El usuario $id_usuario no existe.");
    }

    $registro = mysqli_fetch_assoc($resultset);

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

// Trae TODOS los usuarios
function traerTodosUsuarios(){

  try {

    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error en la conexión: " . mysqli_connect_errno());
    }

    $consulta = "SELECT * FROM usuarios";

    $resultset = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultset) == 0){

      throw new Exception("Error al recuperar los usuarios.");
    }

    $arrayRegistros = array();

    while($registro = mysqli_fetch_assoc($resultset)){

      $arrayRegistros[] = $registro;

    }

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