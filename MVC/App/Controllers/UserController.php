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

    //Additional parameters
    $parameters = [
      "title"=>"Cerrar sesión",
      "href"=>ROOT."/user/logout"
    ];

    $this->render("useraccount", $parameters, "user");
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
}

?>