<?php

require_once(__DIR__ . "/../Core/Model.php");

class Product extends Model{

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    parent::__construct('id_producto', 'productos', $connection);
  }

  public function paginateSearch($page, $limit, $search=''){  
    
    try {
      //Dynamic Query
      if($search != ''){
        $where = "WHERE nombre_producto LIKE '%$search%' OR descripcion LIKE '%$search%' ";
      }

      //Page Count
      $rows = $this->db->query("SELECT COUNT(*) FROM {$this->table} $where")->fetchColumn();
      $pages = ceil($rows / $limit);

      $offset = ($page-1) * $limit;
      $query = "SELECT * FROM {$this->table} $where LIMIT $offset, $limit";

      //Execute Query
      $stmt = $this->db->prepare($query);
      $stmt->execute();

      $data = $stmt->fetchAll();

      return [
        "data" => $data,
        "page" => $page,
        "limit" => $limit,
        "pages" => $pages,
        "rows" => $rows
      ];
    } catch (\Throwable $e) {
      
      return "Error: {$e->getMessage()}";
    }
    
  }



}

?>