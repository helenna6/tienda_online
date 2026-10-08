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
            isset($_POST['stock'])
        ){
            $db = DB::connect();
            $q = "INSERT INTO PRODUCT (name, description, price, stock, user_id) VALUES (
            '".$_POST['name']."','".$_POST['description']."',".$_POST['price'].",".$_POST['stock'].",
            ".$_SESSION['user']->getId().")";
            $db->query($q);
        }
        header("Location: index.php");
        exit;
    }
?>