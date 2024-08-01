<?php

require_once(__DIR__ . "/../Core/Model.php");

class Sales extends Model{

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    parent::__construct('id_venta', 'ventas', $connection);
  }

  /* ---------------------- Functions ---------------------- */

  function getAllUserPurchases($user_id){

    try {
      $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE fk_usuario=:userid");
      $stmt->bindValue(":userid", $user_id);
      $stmt->execute();

      //Retorna todos los registros
      return $stmt->fetchAll();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";

    }
  }


}

?>