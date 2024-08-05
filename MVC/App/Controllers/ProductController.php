<?php

require_once(__DIR__ . "/../Models/Product.php");
// MercadoPago namespaces
use \MercadoPago\Client\Preference\PreferenceClient;
use \MercadoPago\MercadoPagoConfig;

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

  public function showProduct(){

    if(session_status() === PHP_SESSION_NONE){
      session_start();
    }

    if(isset($_GET['product'])){

      $product_id = $_GET['product'];

      // GET product data
      $product_data = $this->productModel->getById($product_id); 

      if(is_array($product_data)){

        $this->render("showproduct", [
          "product"=>$product_data
        ], "user");

      }else{
        $this->error();

      }

    }else{
      $this->error();
    }
  }

  public function createMPPreference(){

    // Response
    $res = new Result();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      session_start();

      $prod_id = $_POST['prod_id'];
      $prod_name = $_POST['prod_name'];
      $prod_price = (int)str_replace(",",".", str_replace(".", "", $_POST['prod_price']));
      $prod_quantity = isset($_POST['prod_quantity']) ? (int)$_POST['prod_quantity'] : 1;
      $prod_description = isset($_POST['prod_description']) ? $_POST['prod_description'] : "";
      $prod_photo = isset($_POST['prod_photo']) ? $_POST['prod_photo'] : "";
      $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "";
      $user_lastname = isset($_SESSION['user_lastname']) ? $_SESSION['user_lastname'] : "";
      $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : "";

      // ----- MercadoPago preferences -----
      MercadoPagoConfig::setAccessToken(MP_PRIVATE_KEY);
      $client = new PreferenceClient();

      // Redirections
      $backUrls = [
        "success" => "localhost".ROOT."/user/successfulPayment",
        "failure" => "localhost".ROOT."/user/failedPayment",
      ];

      $preference = $client->create([
        // Productos
        "items"=>[
          // Prod 1
          [
            "id" => $prod_id,
            "title"=> $prod_name,
            "quantity"=> $prod_quantity,
            "unit_price"=> $prod_price,
            // Detalles opcionales
            "picture_url" => __DIR__."/Assets/images/$prod_photo",
            "currency_id" => "ARS"
          ]
        ],
        // Customer Data
        "payer" => [
          "name" => "$user_name",
          "surname" => "$user_lastname",
          "email" => "$user_email"
        ],
        // Redirection URLs
        "back_urls" => $backUrls,
        // Returns to the page automatically
        "auto_return" => "approved",
        // Only successful/failed payment (NOT PENDING)
        "binary_mode" => true,
        // Market name
        "statent_descriptor"=>"Salon de Belleza M&G",
        // Payment ID
        "external_reference"=>"P$prod_id-C$prod_quantity"
        // Webhook URL (payment notification)
        //"notification_url" => "https://salondebelleza.com/public/sales/paymentWebhook"
      ]);
      

      $res->success = true;
      $res->result = $preference->id;
      $res->message = "Preferences created";
    }else{

      $res->success = false;
      $res->result = "";
      $res->message = "Request method not allowed";

    }

    echo json_encode($res);

  }
}

?>