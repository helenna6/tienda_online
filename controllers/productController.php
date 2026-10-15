<?php
    if(isset($_GET['new'])){
        require_once("views/newProduct.phtml");
        exit;
    }
    if(isset($_GET['add'])){
        if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) &&
        isset($_POST['stock']) && isset($_SESSION['user'])){
            $db = DB::connect();
            $name = $db->real_escape_string($_POST['name']);
            $description = $db->real_escape_string($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $userId = $_SESSION['user']->getId();
            $q = "INSERT INTO PRODUCT (name, description, price, stock, user_id) VALUES ('".$name."',
            '".$description."',".$price.",".$stock.",".$userId.")";
            if($db->query($q)){
                header("Location: index.php?productAdded=1");
                exit;
            }else{
                echo "Error al añadir el producto: ".$db->error;
                exit;
            }
        }else{
            echo "Faltan datos o no has iniciado sesión.";
            exit;
        }
    }
?>
