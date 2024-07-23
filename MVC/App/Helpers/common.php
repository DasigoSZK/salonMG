<?php

class Result{

  // Response true/false
  public $success;
  // JSON data
  public $result;
  // Server message
  public $message;

  public function __construct(){

    $this->success = false;
    $this->result = []; 
    $this->message = ""; 
  }

}


?>