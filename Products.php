<?php
require './vendor/autoload.php';
$app = new Slim\App;
$app->get('/api/test', function ($request, $response) {
    return 'hello world';
});
$app->get('/api/products', function ($request, $response) {
    header("Content-Type: application/json");
    getProducts();
});
$app->get('/api/product/{productID}', function ($request, $response, $args) {
    //return '{"data":"' . $args['id'] . '"}'; 
    $id = $request ->getAttribute('productID');
    header("Content-Type: application/json");
    getProduct();
});


$app->run();


function getProducts() {
    $sql = "SELECT * FROM product";
      try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    }


    function getProduct() {
        $sql = "SELECT * FROM product WHERE productID = $id";
          try {
            $db = getConnection();
            $stmt = $db->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo json_encode($products);
          }
          catch(PDOException $e) {
            echo json_encode($e->getMessage());
          }
        }
function getConnection() {
    $dbhost="sql12.freemysqlhosting.net";
    $dbuser="sql12235819";
    $dbpass="HILAldVgjQ";
    $dbname="sql12235819";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
?>