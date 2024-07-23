<?php

class Router{

  private $controller;
  private $method;

  // ------------- Constructor -------------
  public function __construct(){

    $this->getRoute();
  }





  // ------------- Functions -------------
  public function getRoute(){

    $arrayPath = explode("/", PATH);

    $this->controller = !empty($arrayPath[0]) ? ucfirst($arrayPath[0]) : 'User';
    $this->method = !empty($arrayPath[1]) ? $arrayPath[1] : 'home';
    $this->controller = $this->controller . "Controller";
    //Removes any additional parameter
    if(str_contains($this->method, "?")){
      $this->method = strstr($this->method, "?", true); 
    }

    //If controller exists
    if(file_exists(__DIR__ . "/Controllers/{$this->controller}.php")){

      require_once(__DIR__ . "/Controllers/{$this->controller}.php");
      //If controller doesn't have the method
      if(!method_exists($this->controller, $this->method)){
        $this->method = 'error';
      }
      
    //If controller doesn't exists
    }else{

      $this->controller = "UserController";
      $this->method = 'error';
      require_once(__DIR__ . "/Controllers/{$this->controller}.php");
    }

    
  }

  public function run(){

    //Database
    $db = new Database();
    $connection = $db->getConnection();

    //Controller
    $controller = new $this->controller($connection);
    $method = $this->method;
    
    //Render Controller View
    $controller->$method();
  }

  
}

?>