<?php
if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){
    if(isset($_POST['name']) && isset($_POST['price']) && isset($_POST['stock'])){
        ProductRepository::addProduct($_POST['name'], $_POST['price'], $_POST['stock']);
    }
    header("Location: index.php");
    exit;
}
?>