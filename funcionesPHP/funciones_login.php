<?php

require_once 'conectar.php';

// Limpia los datos para registrarlos en la BBDD
function limpiarDatos(&$conexion, &...$datos){

  if(!$conexion) return false;

  // Modifica las variables por referencia (&)
  foreach($datos as &$dato){

    // Quita los espacios al inicio y al final
    $dato = trim($dato);
    // Escapa caracteres que podrían ser interpretados como HTML
    $dato = htmlspecialchars($dato);
    // Escapa caracteres que podrían ser interpretados por código SQL
    $dato = mysqli_real_escape_string($conexion, $dato);
  }

  return true;

}

// Registra un usuario por primera vez (limpia los datos, encripta la contraseña y maneja si el correo ya existe)
function registrarUsuario($nombre, $apellido, $telefono, $correo, $contra){

  try {
  
    //Conexion
    $conexion = conectar();

    if($conexion == null){

      throw new Exception("No se logró establecer la conexión con la base de datos.");
    }

    //Limpiamos los datos
    if(!limpiarDatos($conexion, $nombre, $apellido, $telefono, $correo, $contra)){

      throw new Exception("No se logró limpiar los datos, posible error en la conexión.");
    }

    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){

      mysqli_close($conexion);
      header("Location: ../registrar_usuario.php?correoNoValido");
      return false;
    }

    //Encriptamos la contraseña
    $contra = password_hash($contra, PASSWORD_DEFAULT);

    //Insertamos en la BBDD
    $consulta = "INSERT INTO usuarios (nombre, apellido, telefono, correo, contrasena, fk_tipo_usuario) VALUES
                  ('$nombre', '$apellido', '$telefono', '$correo', '$contrasena', 1)";

    if(!mysqli_query($conexion, $consulta)){

      // Si el error fue debido a CORREO REPETIDO
      if(mysqli_errno($conexion) == 1062){

        mysqli_close($conexion);
        header("Location: ../index.php?correoExistente");
        return false;

      // Si fue por otro error
      }else{

        throw new Exception("Error al registrar el usuario. Código: " .  mysqli_errno($conexion));
      }
    }

    mysqli_close($conexion);

    // Devuelve TRUE si se registró exitosamente
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

// Verifica si existe el correo (usuario), compara las contraseñas
function loguearUsuario($correo, $contra){

  try {
    
    $conexion = conectar();

    if($conexion == null){

      throw new Exception("Error al conectarse con la base de datos.");
    }

    // Limpiamos los datos
    if(!limpiarDatos($conexion, $correo, $contra)){

      throw new Exception("Error al limpiar los datos, posible error en la conexión.");
    }

    // Obtenemos el usuario asociado al correo
    $consulta = "SELECT * FROM usuarios WHERE correo=$correo";
    $resultset = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultset) == 0){

      mysqli_close($conexion);
      header("Location: loguear_usuario.php?usuarioInexistente");
      exit();
    }

    // Validamos la contraseña del usuario
    $usuario = mysqli_fetch_assoc($resultset);

    if(password_verify($contra, $usuario['contrasena'])){

      // Guardamos en sesión sus datos
      session_start();
      $_SESSION['id_usuario'] = $usuario['id_usuario'];
      $_SESSION['nombre'] = $usuario['nombre'];
      $_SESSION['apellido'] = $usuario['apellido'];
      $_SESSION['telefono'] = $usuario['telefono'];
      $_SESSION['correo'] = $usuario['correo'];
      $_SESSION['fk_tipo_usuario'] = $usuario['fk_tipo_usuario'];
      //Cerramos la conexión
      mysqli_close($conexion);
      //Redirigimos al index / administracion
      if($_SESSION['fk_tipo_usuario'] == 1){

        header("Location: index.php");
        exit();
      }else if($_SESSION['fk_tipo_usuario'] == 2){
        
        header("Location: administracion.php");
        exit();
      }

    }else{

      mysqli_close($conexion);
      header("Location: loguear_usuario.php?contrasenaIncorrecta");
      exit();
    }

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


?>