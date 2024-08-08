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
      $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE fk_usuario=:userid ORDER BY fecha DESC");
      $stmt->bindValue(":userid", $user_id);
      $stmt->execute();

      //Retorna todos los registros
      return $stmt->fetchAll();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";

    }
  }

  function confirmPayment($payment_id){

    try {

      $query = "UPDATE {$this->table} SET confirmado=1 WHERE mp_payment_id=:paymentid";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":paymentid", $payment_id);
      $stmt->execute();

      return $stmt->rowCount();

    } catch (\Throwable $e) {

      return "Error: ${$e->getMessage()}";

    }

  }


}

?>