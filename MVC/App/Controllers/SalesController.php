<?php

require_once(__DIR__ . "/../Models/Sales.php");
require_once(__DIR__ . "/../Models/SalesHasProducts.php");

class SalesController extends Controller{

  private $salesModel;
  private $salesHasProductsModel;


  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    $this->salesModel = new Sales($connection);
    $this->salesHasProductsModel = new SalesHasProducts($connection);
  }

  /* ---------------------- Functions ---------------------- */
  function userPurchases(){

    session_start();

    $res = new Result();

    if(isset($_SESSION['user_id'])){

      $user_id = $_SESSION['user_id'];

      // Initial array for $res->result
      $data = [];

      // 1_ Get ALL SALES associated to the user
      $allSales = $this->salesModel->getAllUserPurchases($user_id);
      if(is_array($allSales) && !empty($allSales)){
        foreach($allSales as $sale){
          $arraySale = [
            "id_venta" => $sale['id_venta'],
            "fecha" => $sale['fecha'],
            "monto_total" => $sale['monto'],
            "productos" => []
          ];
          array_push($data, $arraySale);
        }

        // 2_ Get ALL PRODUCTS associated with each SALE
        for($i=0; $i<count($data); $i++){

          $id_sale = $data[$i]['id_venta']; 
          $associatedProducts = $this->salesHasProductsModel->getAssociatedProducts($id_sale);

          // Push each product into $data[$i]['productos']
          foreach($associatedProducts as $product){
            $arrayProduct = [
              "id"=>$product['id_producto'],
              "nombre"=>$product['nombre_producto'],
              "cantidad_comprada"=>$product['cantidad'],
              "precio"=>$product['precio'],
              "foto"=>$product['foto']
            ];

            array_push($data[$i]['productos'], $arrayProduct);
          }
        }

        // 3_ Return res with data
        $res->success = true;
        $res->result = $data;
        $res->message = "User purchases retrieved successfully";

      }else{

        // The user didn't buy nothing yet
        $res->success = false;
        $res->result = null;
        $res->message = "Aún no se han realizado compras...";
      }
        
      

    }else{

      $res->success = false;
      $res->result = null;
      $res->message = "El usuario no se encuentra logueado.";

    }

    echo json_encode($res);

  }

}

?>