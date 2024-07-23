<?php

//Datos de la conexión
require_once '../config/config.php';

//Devuelve un objeto PDO configurado para la DB
class Conexion{

  protected $conexionDB;

  public function __construct(){

    try {

      $this->conexionDB = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NOMBRE, DB_USUARIO, DB_PASS);
      $this->conexionDB->setAttribute(PDO::ATTR_ERRRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conexionDB->exec("SET CHARACTER SET utf8");
      
    } catch (\Throwable $e) {

      echo "Ocurrió un error al conectarse con la base de datos.<br>";
      echo "Línea: " . $e->getLine() . "<br>";
      echo "Código: " . $e->getCode() . "<br>";
      echo $e->getMessage() . "<br>";
      
    }

  }

}

?>