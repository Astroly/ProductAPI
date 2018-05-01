<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
$app = new \Slim\App;

//Get All Products
$app->get('/api/product', function(Request $request, Response $response){
    // $sql = "SELECT productID,title,description,price,pic FROM product";
    $sql = "SELECT * FROM product";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
        // var_dump($products);


    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//GET Single Product
$app->get('/api/product/{productID}',function(Request $request, Response $response){
    $id = $request ->getAttribute('productID');
    $sql = "SELECT * FROM product WHERE productID = $id";
    
    try {
        $db = new db();
        $db = $db->connect();

         $stmt =$db->query($sql);

        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($product);
    }catch(PDOException $e){
        echo'{"error":{"text":}'.$e->getMessage().'}';
    }
});

//Add Products

$app->post('/api/product/add',function(Request $request, Response $response) {

    $productID = $request->getParam('productID') ;

    $title = $request->getParam('title') ;

    $description = $request->getParam('description') ;

    $price = $request->getParam('price') ;
    $pic = $request->getParam('pic') ;



    $sql ="INSERT INTO product (productID,title,description,price,pic) VALUES (:productID,:title,:description,:price,:pic)" ;

    try {

        //get DB object

        $db = new db() ;

        //connect

        $db = $db->connect() ;



        $stmt = $db->prepare($sql) ;



        $stmt->bindParam(':productID',    $productID) ;

        $stmt->bindParam(':title',     $title) ;

        $stmt->bindParam(':description',    $description) ;

        $stmt->bindParam(':price',    $price) ;
        $stmt->bindParam(':pic',    $pic) ;



        $stmt->execute() ;

        echo '{"notice: {"text": "Product Add"}' ;



    } catch(PDOExcaption $e) {

            echo '{"error":{"text": '.$e->getMessage().'}' ;

    }

});



//Update Products

$app->put('/api/product/update/{id}',function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $title = $request->getParam('title') ;

    $description = $request->getParam('description') ;

    $price = $request->getParam('price') ;
    $pic = $request->getParam('pic') ;
    



    $sql = "UPDATE product SET

            title = :title,

            description = :description,

            price = :price,
            pic = :pic

            WHERE productID=$id" ;

    try{

        //Get DB Object

        $db = new db() ;

        // Connect

        $db = $db->connect() ;



        $stmt = $db->prepare($sql) ;



        // $stmt->bindParam(':productID',    $productID) ;

        $stmt->bindParam(':title',     $title) ;

        $stmt->bindParam(':description',    $description) ;

        $stmt->bindParam(':price',    $price) ;
        $stmt->bindParam(':pic',    $pic) ;



        $stmt->execute() ;

        echo '{"notice": {"text": "Product Update"}' ;



    } catch(PODExution $e) {

        echo '{"error": {"text": '.$e->getMessage().'}' ;

    }

});



//Delete Product

$app->delete('/api/product/delete/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    $sql = "DELETE FROM product WHERE productID=$id";

    try{

        //Get DB Object

        $db = new db();

        //connect

        $db = $db->connect();



        $stmt = $db->prepare($sql);

        $stmt->execute();

        $db = null;

        echo '{"notice": {"text": "Product Deleted"}';



    }  catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';

    }



});

?>