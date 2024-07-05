<?php

function conectar(){

  $server = 'localhost';
  $user = 'root';
  $pass = '';
  $dbname = 'salon_de_belleza';
  $port = '3306';

  $conexion = mysqli_connect($server, $user, $pass, $dbname, $port);

  if(!$conexion){

    echo "<b style='color:red'>Error de conexión</b><br>Código: " . mysqli_connect_errno() . "<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    return null;

  }else{

    return $conexion;

  }

}


?>