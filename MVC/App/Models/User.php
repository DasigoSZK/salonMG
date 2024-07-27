<?php

require_once(__DIR__ . "/../Core/Model.php");

class User extends Model{

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    parent::__construct('id_usuario', 'usuarios', $connection);
  }

  public function autenticateUser($mail="", $password="", $rememberUser=false){

    try {

      $tokenValidated = false;

      // -------------- If the user has a validaton cookie --------------
      if(isset($_COOKIE['token']) && ($mail == "" && $password == "")){

        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE token=:token");
        $stmt->bindValue(":token", $_COOKIE['token']);
        $stmt->execute();

        if($stmt->rowCount() != 0){
          $user = $stmt->fetch();
          $expTokenBD = $user['exp_token'];

          //If the cookie expired
          if(time() > strtotime($expTokenBD)){
            throw new Exception("El token de validación a expirado.\nVuelve a iniciar sesión.");
          }else{
            $tokenValidated = true;
          }

        }else{

          throw new Exception("No se reconoce el token del usuario, vuelva a iniciar sesión.");
        }

      }else{

        // -------------- if the user enters mail and password --------------
        // Recover user by email
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo=:correo");
        $stmt->bindValue(":correo", $mail);
        $stmt->execute();

        if($stmt->rowCount() <= 0){
          throw new Exception("El correo ingresado no se encuentra registrado.");
        }

        $user = $stmt->fetch();
      }

      
      // Validate password OR token
      if(password_verify($password, $user['contrasena']) || $tokenValidated){

        // Loads user data into the session
        session_start();
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_lastname'] = $user['apellido'];
        $_SESSION['user_phone'] = $user['telefono'];
        $_SESSION['user_mail'] = $user['correo'];
        $_SESSION['user_type'] = $user['fk_tipo_usuario'];
        if($rememberUser){
          $token = $this->getToken($_SESSION['user_id']);
          if($token != false){
            setCookie("token", $token, time()+(3600*24*7));
          }
        }

        return [
          "autenticated"=>true,
          "message"=>"",
          "user_type"=>$_SESSION['user_type']
        ];

      }else{

        throw new Exception('Correo y/o contraseña incorrectos.');
      }
      
    } catch (\Throwable $e) {

      $message = $e->getMessage();

      return [
        "autenticated"=>false,
        "message"=>$message,
        "user_type"=>""
      ];
      
    }

  }

  public function getToken($id_usuario){

    try {

      $token = bin2hex(random_bytes(16));
      $expiracionTimestamp = time() + (3600*24*7); //El token durará 1 semana
      $expiracion = date('Y-m-d H:i:s', $expiracionTimestamp);

      $stmt = $this->db->prepare("UPDATE usuarios SET token=:token, exp_token=:exp_token WHERE id_usuario=:id_user");
      $stmt->bindValue(":token", $token);
      $stmt->bindValue(":exp_token", $expiracion);
      $stmt->bindValue(":id_user", $id_usuario);
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

  public function registerUser($name, $lastname, $phone, $mail, $password, $user_type){

    try { 
      // ---------- VALIDATIONS ----------
      if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){

        throw new Exception("El correo ingresado no tiene un fomato válido...");
      }
      // Password Hashing (BLOWFISH)
      $password = password_hash($password, PASSWORD_DEFAULT);



      // ---------- QUERY ----------
      $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, apellido, telefono, correo, contrasena, fk_tipo_usuario) VALUES
      (:names, :lastname, :phone, :mail, :pass, :user_type)");
      $stmt->bindValue(":names", $name);
      $stmt->bindValue(":lastname", $lastname);
      $stmt->bindValue(":phone", $phone);
      $stmt->bindValue(":mail", $mail);
      $stmt->bindValue(":pass", $password);
      $stmt->bindValue(":user_type", $user_type);
      if($stmt->execute()){

        if($stmt->rowCount() <= 0){
          $errorInfo = $stmt->errorInfo();
          $errorCodigo = $errorInfo[0];
          $errorMensaje = $errorInfo[2];
          throw new Exception("Ocurrió un error en el registro.<br>Código: $errorCodigo <br>Mensaje: $errorMensaje");

        }else{

          return [
            "status"=>true,
            "message"=>"Usuario registrado con éxito",
            "code"=>""
          ];

        }
      }else{
        $errorInfo = $stmt->errorInfo();
        $errorMessage = "SQLSTATE: " . $errorInfo[0] . "\nError Code: " . $errorInfo[1] . "\nMessage: " . $errorInfo[2];
        throw new Exception($errorMessage);
      }

    } catch (\Throwable $e) {

      $message = $e->getMessage();
      $code = $e->getCode() ? $e->getCode() : 0;

      return [
        "status"=>false,
        "message"=>$message,
        "code"=>$code
      ];
      
    }
  }



}

?>