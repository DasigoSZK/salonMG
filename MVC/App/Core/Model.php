<?php

abstract class Model {

  protected $id;      //"Primary Key" de la tabla
  protected $table;   //Nombre de la tabla
  protected $db;      //Conexión con la DB


  /* ---------------------- Constructor ---------------------- */
  public function __construct($id, $table, PDO $conexion){

    $this->id = $id;
    $this->table = $table;
    $this->db = $conexion;
  }



  /* ---------------------- Functions ---------------------- */

  public function getAll(){

    try {
      $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
      $stmt->execute();

      //Retorna todos los registros
      return $stmt->fetchAll();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";

    }
    
  }

  public function getById($id){

    try {
      $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->id}=:id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      //Retorna 1 registro
      return $stmt->fetch();
    } catch (\Throwable $e) {

      return "Error: ${$e->getMessage()}";
    } 
  }

  public function deleteById($id){

    try {
      $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->id}=:id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      //Devuelve la cantidad de filas afectadas
      return $stmt->rowCount();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";
    }
  }

  public function updateById($id, $data){

    try {
      //Dynamic Query
      $query = "UPDATE {$this->table} SET ";
      foreach($data as $key => $value){
        $query .= "{$key}=:{$key}, ";
      }
      $query = trim($query, " ");
      $query = trim($query, ",");

      $query .= " WHERE {$this->id}=:id";



      //Execute Query
      $stmt = $this->db->prepare($query);
      foreach($data as $key=>$value){
        $stmt->bindValue(":{$key}", $value);
      }
      $stmt->bindValue(":id", $id);
      $stmt->execute();

      return $stmt->rowCount();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";

    }
    
  }

  public function insert($data){

    try {
      //Dynamic Query
      $query = "INSERT INTO {$this->table} (";
      foreach($data as $key=>$value){
        $query .= "{$key}, ";
      }
      $query = trim(trim($query, " "), ",");
      //INSERT INTO clientes (campo1, campo2, campo3
      $query .= ") VALUES (";
      foreach($data as $key=>$value){
        $query .= ":{$key}, ";
      }
      $query = trim(trim($query, " "), ",");
      $query .= ");";
      //INSERT INTO clientes (campo1, campo2, campo3) VALUES (:valor1, :valor2, :valor3)


      //Execute Query
      $stmt = $this->db->prepare($query);
      foreach($data as $key=>$value){
        $stmt->bindValue(":{$key}", $value);
      }
      $stmt->execute();

      return $stmt->rowCount();

    } catch (\Throwable $e) {
      
      return "Error: ${$e->getMessage()}";
    }
    
  }

  public function paginate($page, $limit){  
    
    try {
      //Page Count
      $rows = $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
      $pages = ceil($rows / $limit);

      //Dynamic Query
      $offset = ($page-1) * $limit;
      $query = "SELECT * FROM {$this->table} LIMIT $offset, $limit";

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

  public function lastInsertId(){

    try {
      
      return $this->db->lastInsertId();

    } catch (\Throwable $e) {
      
      return $e->getMessage();

    }
  }
}


?>