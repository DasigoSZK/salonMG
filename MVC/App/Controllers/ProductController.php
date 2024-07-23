<?php

require_once(__DIR__ . "/../Models/Product.php");

class ProductController extends Controller{

  private $productModel;

  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    $this->productModel = new Product($connection);
  }

  /* ---------------------- Functions ---------------------- */
  public function marketProducts(){

    //Pagination ?? 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if(isset($_GET['search'])){
      $search = $_GET['search'];
      $paginatedProducts = $this->productModel->paginateSearch($page, 20, $search);
    }else{
      $paginatedProducts = $this->productModel->paginate($page, 20);
    }


    //Response
    $res = new Result();

    $res->success = is_array($paginatedProducts) ? true : false;
    $res->result = is_array($paginatedProducts) ? $paginatedProducts : null;
    $res->message = is_array($paginatedProducts) ? '' : $paginatedProducts;

    echo json_encode($res);
  }
}

?>