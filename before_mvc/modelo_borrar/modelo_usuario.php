<?php

require_once 'conexion.php';

class Usuario extends Conexion{

  protected $id;
  protected $nombre;
  protected $apellido;
  protected $correo;
  protected $telefono;
  protected $rol;

  // ------------------ Constructor ------------------
  //1_Sin parámetros
  public function __construct(){

    //Llama al constructor de la SUPERCLASE ($conexionDB)
    parent::__construct(); 
  }

  //2_Con parámetros (para crear un futuro ADMINISTRADOR)
  public function __construct($id, $nombre, $apellido, $correo, $telefono, $rol){
    
    //Llama al constructor de la SUPERCLASE ($conexionDB)
    parent::__construct(); 

    //Seteamos los valores
    $this->id = $id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->correo = $correo;
    $this->telefono = $telefono;
    $this->rol = $rol;
  }




  // ------------------ Funciones ------------------
  public function registrarUsuario($nombre, $apellido, $telefono, $correo, $contrasena){

    try {
      
      //Validaciones
      if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){

        throw new Exception("El correo ingresado no tiene un fomato válido...");
      }

      //Encriptado
      $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

      //Consulta Preparada
      $stmt = $this->conexionDB->prepare("INSERT INTO usuarios (nombre, apellido, telefono, correo, contrasena) VALUES 
                                          (:nom, :ape, :telef, :correo, :contra)");

      $stmt->bindParam(':nom', $nombre);
      $stmt->bindParam(':ape', $apellido);
      $stmt->bindParam(':telef', $telefono);
      $stmt->bindParam(':correo', $correo);
      $stmt->bindParam(':contra', $contrasena);

      $stmt->execute();

      //Respuesta
      if($stmt->rowCount() > 0){

        return true;
      }else{
        $errorInfo = $stmt->errorInfo();
        $errorCodigo = $errorInfo[0];
        $errorMensaje = $errorInfo[2];
        throw new Exception("Ocurrió un error en el registro.<br>Código: $errorCodigo <br>Mensaje: $errorMensaje");
      }

    } catch (\Throwable $e) {
      
      echo $e->getMessage();

      return false;

    }

    

  }

  //Devuelve "autenticado" si es exitoso
  public function iniciarSesion($correo=null, $contrasena=null, $recordarme=0){

    try {

      //Si el usuario checkeo la casilla "recordarme"
      isset(isset($_COOKIE['token'])){

        return recordarUsuario($_COOKIE['token']);
      }

      // -------------------------------------------------------------------------------

      //Recuperación de USUARIO
      $stmt = $this->conexionDB->prepare("SELECT * FROM usuarios WHERE $correo=:correo");
      $stmt->bindParam(":correo", $correo);
      $stmt->execute();



      //Validación de contraseña
      if($stmt->rowCount() > 0){

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($contrasena, $usuario['contrasena'])){

          //Guardamos el usuario en sesión
          $this->id = $usuario['id_usuario'];
          $this->nombre = $usuario['nombre'];
          $this->apellido = $usuario['apellido'];
          $this->correo = $usuario['correo'];
          $this->telefono = $usuario['telefono'];
          $this->rol = $usuario['fk_tipo_usuario'];
          if($recordarme == 1){
            $token = $this->crearToken($this->id);
            setCookie("token", $token, time()+(3600*24*7));
          }

          session_start();
          $_SESSION['usuario'] = $this;

          return "autenticado";
        }else{

          throw new Exception("La contraseña ingresada no es correcta...");
        }

      }else{

        throw new Exception("El correo ingresado no se encuentra registrado...");
      }


    } catch (\Throwable $e) {
      
      return $e->getMessage();

    }
  }

  public function crearToken($id_usuario){

    try {

      $token = bin2hex(random_bytes(16));
      $expiracion = time() + (3600*24*7); //El token durará 1 semana

      $stmt = $this->conexionDB->prepare("UPDATE usuarios SET token=:token, exp_token=:expiracion WHERE id_usuario=:id_usuario");
      $stmt->bindParam(":token", $token);
      $stmt->bindParam(":exp_token", $expiracion);
      $stmt->bindParam(":id_usuario", $id_usuario);
      $stmt->execute();

      if($stmt->rowCount() != 0){

        return $token;
      }else{

        throw new Exception("Error al crear el token para el usuario $id_usuario");
      }
      
    } catch (\Throwable $e) {

      echo $e->getMessage();
      return false;
      
    }
    
  }

  //Devuelve "autenticado" si es exitoso
  public function recordarSesion($token){

    try {
      
      $stmt = $this->conexionDB->prepare("SELECT * FROM usuarios WHERE token=:token");
      $stmt->bindParam(":token", $token);
      $stmt->execute();

      //Si el token existe
      if($stmt->rowCount() != 0){

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Si la cookie no expiró
        if(time() <= $usuario['exp_token']){

          //Guardamos el usuario en sesión
          $this->id = $usuario['id_usuario'];
          $this->nombre = $usuario['nombre'];
          $this->apellido = $usuario['apellido'];
          $this->correo = $usuario['correo'];
          $this->telefono = $usuario['telefono'];
          $this->rol = $usuario['fk_tipo_usuario'];

          session_start();
          $_SESSION['usuario'] = $this;

          return "autenticado";

        }else{

          throw new Exception("Tu sesión ya expiró, debes volver a ingresar.");
        }

          

      }else{

          throw new Exception("Tu sesión ya expiró, debes volver a ingresar.");
      }

    } catch (\Throwable $e) {

      //Eliminamos la cookie
      setCookie("token", "", time()-100);
      return $e->getMessage();
    }
  }
}

?>