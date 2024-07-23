<?php

class Database{

  private $connection;

  // ------------- Constructor -------------
  public function __construct(){

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $this->connection = new PDO("mysql:host=".SERVER.";dbname=".DBNAME, USER, PASS, $options);

    $this->connection->exec("SET CHARACTER SET UTF8");

  }

  // ------------- Functions -------------
  public function getConnection(){

    return $this->connection;
  }

  public function closeConnection(){

    $this->connection = null;
  }
}


?>