<?php

class Controller {

  // Renders a VIEW
  protected function render($path, $parameters = [], $layout = ""){

    //Starts a buffer
    ob_start();
    //VIEW CONTENT --> BUFFER
    require_once(__DIR__ . "/../Views/{$path}_view.php");
    //Saves buffer content
    $content = ob_get_clean();
    
    //Renders a LAYOUT with the VIEW inside "$content"
    require_once(__DIR__ . "/../Views/layouts/{$layout}_layout.php");
  }

  public function error(){
    //Starts a buffer
    ob_start();
    //VIEW CONTENT --> BUFFER
    require_once(__DIR__ . "/../Views/error_view.php");
    //Saves buffer content
    $content = ob_get_clean();
    
    //Renders a LAYOUT with the VIEW inside "$content"
    require_once(__DIR__ . "/../Views/layouts/user_layout.php");
  }
}

?>