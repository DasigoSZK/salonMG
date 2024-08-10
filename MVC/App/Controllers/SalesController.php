<?php

require_once(__DIR__ . "/../Models/Sales.php");
require_once(__DIR__ . "/../Models/SalesHasProducts.php");
// MercadoPago namespaces
use \MercadoPago\Client\Preference\PreferenceClient;
use \MercadoPago\MercadoPagoConfig;

class SalesController extends Controller{

  private $salesModel;
  private $salesHasProductsModel;


  /* ---------------------- Constructor ---------------------- */
  public function __construct(PDO $connection){

    $this->salesModel = new Sales($connection);
    $this->salesHasProductsModel = new SalesHasProducts($connection);
  }

  /* ---------------------- Functions ---------------------- */
  public function userPurchases(){

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
            "confirmado" => $sale['confirmado'] ? true : false,
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

  // NOT IMPLEMENTED YET
  public function paymentWebHook(){

    // Gets the MP notification
    $MPNotification = filet_get_contents("php://input");
    $data = json_decode($MPNotification, true);

    if(isset($data['type']) && $data['type'] == 'payment'){

      // Recover customer data
      $paymentId = $data['data']['id'];
      $customer = new PaymentClient();
      $payment = $customer->get($paymentId);

      // Recover payment id
      $payment_id = $payment->id;

      // Confirm the payment of the product
      $this->salesModel->confirmPayment($payment_id);
    }

    http_response_code(200);

  }

  public function loadSale(){

    if(session_status() === PHP_SESSION_NONE){
      session_start();
    }

    // {user_id: 1, products: [{"prod_id": prod_id, "prod_price": prod_price, "prod_quantity": prod_quantity}]}
    $JSONdata = file_get_contents('php://input');

    $data = json_decode($JSONdata, true);

    $user_id = $data['user_id'];
    $products = $data['products'];

    // Sale DATA
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha = date('Y-m-d H:i:s');
    $monto = 0;
    foreach($products as $prod){
      $monto += ($prod['prod_price'] * $prod['prod_quantity']);
    }

    // Inserts a "venta"
    $this->salesModel->insert(['fecha'=>$fecha, 'monto'=>$monto, 'fk_usuario'=>$user_id]);
    // last "venta" id
    $venta_id = $this->salesModel->lastInsertId();
    $_SESSION['lastpurchase_id'] = $venta_id;

    // Creates a "ventas_has_productos" for each associated product
    foreach($products as $prod){
      $this->salesHasProductsModel->insert(['fk_venta'=>$venta_id, 'fk_producto'=>$prod['prod_id'], 'cantidad'=>$prod['prod_quantity']]);
    }


  }

  public function loadPaymentId(){

    session_start();

    // Gets JSON data
    $JSONdata = file_get_contents('php://input');

    $data = json_decode($JSONdata, true);
    $payment_id = $data['payment_id'];
    $venta_id = $_SESSION['lastpurchase_id'];

    // Loads payment_id into the last "venta"
    $bdres = $this->salesModel->updateById($venta_id, ['mp_payment_id'=>$payment_id]);

    unset($_SESSION['lastpurchase_id']);

    echo json_encode($bdres);
  }

  public function deleteLastPurchase(){

    session_start();

    // Gets JSON data
    $venta_id = $_SESSION['lastpurchase_id'];

    // Deletes each "venta_has_product" associated to "venta"
    $this->salesHasProductsModel->deleteAssociatedProducts($venta_id);

    // Deletes "venta"
    $bdres = $this->salesModel->deleteById($venta_id);

    unset($_SESSION['lastpurchase_id']);

    echo json_encode($bdres);
  }



}

?>