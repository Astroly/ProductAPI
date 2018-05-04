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
$app->get('/api/products/{productID}', function ($request, $response, $args) {
    $id = '{productID}';
    //return '{"data":"' . $args['id'] . '"}'; 
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
        //$id = $args->('{productID}');
        $sql = "SELECT * FROM product WHERE productID = $id";
        //return '$args['id']';
        try {
            $db = getConnection();
            $stmt = $db->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo json_encode($product);
        }catch(PDOException $e){
            echo'{"error":{"text":}'.$e->getMessage().'}';
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