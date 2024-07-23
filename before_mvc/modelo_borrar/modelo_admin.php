<?php

require_once "modelo_usuario";

class Admin extends Usuario{

  // ------------------ Constructor ------------------
  public function __construct(Usuario $usuario){

    //Carga los datos del USUARIO al ADMINISTRADOR una vez ya logueado
    parent::__construct($usuario->id, $usuario->nombre, $usuario->apellido, $usuario->correo, $usuario->telefono, $usuario->rol); 
  }



  // ------------------ Funciones ------------------
}

?>