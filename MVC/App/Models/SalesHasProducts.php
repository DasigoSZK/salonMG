<?php

require_once(__DIR__ . "/../Core/Model.php");

class SalesHasProducts extends Model{

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    parent::__construct('id_ventaXproducto', 'ventas_x_productos', $connection);
  }

  /* ---------------------- Functions ---------------------- */
  function getAssociatedProducts($id_sale){

    try {
      $stmt = $this->db->prepare("SELECT p.id_producto, p.nombre_producto, p.precio, p.foto, vp.cantidad
                                  FROM {$this->table} AS vp
                                  INNER JOIN productos AS p
                                    ON vp.fk_producto = p.id_producto
                                  WHERE fk_venta=:idsale");
      $stmt->bindValue(":idsale", $id_sale);
      $stmt->execute();

      //Retorna todos los registros
      return $stmt->fetchAll();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";

    }
  }



}

?>