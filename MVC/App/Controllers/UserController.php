<?php

require_once(__DIR__ . "/../Models/User.php");


class UserController extends Controller{

  private $userModel;

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    $this->userModel = new User($connection);
  }

  /* ---------------------- Functions ---------------------- */
  public function home(){

    session_start();

    $parameters = [];
    if(isset($_SESSION['user_id'])){
      $parameters = [
        "title"=>"Mi cuenta",
        "href"=>ROOT."/user/myAccount"
      ];
    }

    $this->render('home', $parameters, 'user');
  }

  public function market(){

    session_start();

    //Pagination
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $paginatedProducts = $this->userModel->paginate($page, 20);

    //Additional parameters
    $parameters = [
      "paginate"=>$paginatedProducts
    ];
    if(isset($_SESSION['user_id'])){
      $parameters["title"] = "Mi Cuenta";
      $parameters['href'] = ROOT."/user/myAccount";
    }

    $this->render('market', $parameters, 'userMarket');
  }

  public function contact(){

    session_start();

    $parameters = [];
    if(isset($_SESSION['user_id'])){
      $parameters = [
        "title"=>"Mi cuenta",
        "href"=>ROOT."/user/myAccount"
      ];
    }

    $this->render('contact', $parameters, 'user');
  }

  public function faqs(){

    session_start();

    $parameters = [];
    if(isset($_SESSION['user_id'])){
      $parameters = [
        "title"=>"Mi cuenta",
        "href"=>ROOT."/user/myAccount"
      ];
    }

    $this->render('faqs', $parameters, 'user');
  }

  public function aboutus(){

    session_start();

    $parameters = [];
    if(isset($_SESSION['user_id'])){
      $parameters = [
        "title"=>"Mi cuenta",
        "href"=>ROOT."/user/myAccount"
      ];
    }

    $this->render('aboutus', $parameters, 'user');
  }

  public function login(){

    // session_start();
    if(isset($_SESSION['user_id'])){
      $parameters = [
        "title"=>"Mi cuenta",
        "href"=>ROOT."/user/myAccount"
      ];
      $this->render('home', $parameters, 'user');
    }else{

      $this->render('login', [], 'user');
    }
  }

  public function autenticate(){

    $res = new Result();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Capture form data (safe way)
      $userEmail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_STRING);
      $userPassword = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
      // $sesion = filter_input(INPUT_POST, 'sesion', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      // if ($sesion === null) $sesion = false;
      $sesion = isset($_POST['session']) ? true : false;

      // Validate user data
      $autResponse = $this->userModel->autenticateUser($userEmail, $userPassword, $sesion);

      $res->success = $autResponse['autenticated'] ? true : false;
      $res->result = $autResponse['user_type'];
      $res->message = $autResponse['message'];

      echo json_encode($res);

    }else{

      $res->success = false;
      $res->result = null;
      $res->message = 'Error: Method no allowed';

      echo json_encode($res);

    }
  }

  public function myAccount(){

    session_start();
    //Additional parameters
    $parameters = [
      "title"=>"<span style='color:#B22222'>Cerrar sesión</span>",
      "href"=>ROOT."/user/logout"
    ];

    $this->render("useraccount", $parameters, "user");
  }

  public function editAccount(){

    session_start();

    if(isset($_SESSION['user_id'])){
      // Get user info
      $userInfo = $this->userModel->getById($_SESSION['user_id']);

      // Additional parameters
      $parameters = [
        "title"=>"<span style='color:#B22222'>Cerrar sesión</span>",
        "href"=>ROOT."/user/logout",
        "user"=>$userInfo
      ];

      $this->render("useraccount-edit", $parameters, "user");
    }else{

      $this->error();
    }
    
  }

  public function validateUser(){

    $res = new Result();  

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Capture form data (safe way)
      $userID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
      $userPassword = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

      // Validate user data
      $autResponse = $this->userModel->validatePassword($userID, $userPassword);

      $res->success = $autResponse['status'] ? true : false;
      $res->result = "";
      $res->message = $autResponse['message'];

      echo json_encode($res);

    }else{

      $res->success = false;
      $res->result = null;
      $res->message = 'Error: Method no allowed';

      echo json_encode($res);

    }
    
  }

  public function editUser(){

    $res = new Result();  

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // ---- Capture form data (safe way) ----
      $id = isset($_POST['id_user']) ? filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING) : "";
      $name = isset($_POST['name']) ? filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) : "";
      $lastname = isset($_POST['lastname']) ? filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) : "";
      $phone = isset($_POST['phone']) ? filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) : "";
      $mail = isset($_POST['mail']) ? filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_STRING) : "";
      $pass = isset($_POST['pass']) ? filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING) : "";

      // ---- Update user data ----
      if($pass != ""){

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $rowsAffected = $this->userModel->updateById($id, [
          "nombre"=>$name,
          "apellido"=>$lastname,
          "telefono"=>$phone,
          "correo"=>$mail,
          "contrasena"=>$pass
        ]);

      }else{
        $rowsAffected = $this->userModel->updateById($id, [
          "nombre"=>$name,
          "apellido"=>$lastname,
          "telefono"=>$phone,
          "correo"=>$mail
        ]);
      }

      // ---- Res ----
      if($rowsAffected == 0){

        $res->success = false;
        $res->result = null;
        $res->message = "Ocurrió un error al actualizar los datos.";

      }else{

        $res->success = true;
        $res->result = null;
        $res->message = "Los datos se actualizaron exitosamente.";

        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_lastname'] = $lastname;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_mail'] = $mail;
      }

      echo json_encode($res);

    }else{

      $res->success = false;
      $res->result = null;
      $res->message = 'Error: Method no allowed';

      echo json_encode($res);

    }
  }

  public function logout(){

    session_start();
    session_destroy();
    setCookie("token", "", time()-10);

    $this->render("login", [], "user");
  }

  public function signupForm(){

    $this->render("signup", [], "user");
  }

  public function newUser(){

    $res = new Result();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

      //Captura formData (safe way)
      $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
      $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
      $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
      $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_STRING);
      $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
      $user_type = 1;

      $response = $this->userModel->registerUser($name, $lastname, $phone, $mail, $password, $user_type);

      if($response['status'] == true){
        $res->success = true;
        $res->result = null;
        $res->message = "Te registraste como \"$name $lastname\".<br>Ingresa al sitio utilizando tu correo electrónico.";
      }else{

        $message = str_contains($response['message'], "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry")
        ? "El correo ingresado ya se encuentra registrado." 
        : $response['message'];

        $res->success = false;
        $res->result = $response['code'];
        $res->message = $message;
      }

      echo json_encode($res);

    }else{

      $res->success = false;
      $res->result = null;
      $res->message = 'Error: Method no allowed';

      echo json_encode($res);
    }
  }

  public function successfulPayment(){

    if(session_status() === PHP_SESSION_NONE){
      session_start();
    }

    $parameters = [];

    $this->render("successfulPay", $parameters, "user");

  }

  public function failedPayment(){

    if(session_status() === PHP_SESSION_NONE){
      session_start();
    }

    $parameters = [];

    $this->render("failedPayment", $parameters, "user");

  }
}

?>