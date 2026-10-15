<?php
if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){

    if(
        isset($_POST['name']) &&
        isset($_POST['description']) &&
        isset($_POST['price']) &&
        isset($_POST['stock']) &&
        isset($_SESSION['user'])
    ){

        $db = DB::connect();

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        
        $userId = $_SESSION['user']->getId();
        if(empty($userId)){
            die("Error crítico: El usuario actual no tiene un ID válido en la sesión. Cierra sesión, vuelve a iniciarla y prueba de nuevo.");
        }

        $q = "INSERT INTO PRODUCT (name, description, price, stock, user_id)
              VALUES (
                  '".$name."',
                  '".$description."',
                  ".$price.",
                  ".$stock.",
                  ".$userId."
              )";

        $db->query($q);
    }

    header("Location: index.php");
    exit;
}
?>