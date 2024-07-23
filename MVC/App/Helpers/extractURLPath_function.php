<?php

function extractURLPath(){

  $url = $_SERVER['REQUEST_URI'];                 //URL completa, con la ruta "/controlador/metodo"
  $dirname = dirname($_SERVER['SCRIPT_NAME']);    //URL sin la ruta

  //Extraemos la ruta "controlador/metodo"
  $path = substr($url, strlen($dirname));
  $path = ltrim($path, "/");

  return $path;
}

?>