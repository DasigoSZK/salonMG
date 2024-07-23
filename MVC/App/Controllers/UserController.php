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

    $this->render('home', [], 'user');
  }

  public function market(){

    //Pagination
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $paginatedProducts = $this->userModel->paginate($page, 20);

    $this->render('market', ["paginate"=>$paginatedProducts], 'userMarket');
  }

  public function contact(){

    $this->render('contact', [], 'user');
  }

  public function faqs(){

    $this->render('faqs', [], 'user');
  }

  public function aboutus(){

    $this->render('aboutus', [], 'user');
  }
}

?>