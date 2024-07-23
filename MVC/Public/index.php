<?php
// Loads everything
require_once(__DIR__ . "/../App/autoload.php");

// Calls the controller
$router = new Router();
$router->run();

?>