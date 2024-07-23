<?php

require_once(__DIR__ . "/../Core/Model.php");

class User extends Model{

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    parent::__construct('id_usuario', 'usuarios', $connection);
  }



}

?>