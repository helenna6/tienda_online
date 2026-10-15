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

        $name = $db->real_escape_string($_POST['name']);
        $description = $db->real_escape_string($_POST['description']);
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);
        
        $userId = $_SESSION['user']->getId();
        if(empty($userId)){
            die("Error crítico: El usuario actual no tiene un ID válido en la sesión. Cierra sesión, vuelve a iniciarla y prueba de nuevo.");
        }

        $queries = [
            "INSERT INTO products (name, description, price, stock, user_id) VALUES ('$name', '$description', $price, $stock, $userId)",
            "INSERT INTO products (name, description, price, stock) VALUES ('$name', '$description', $price, $stock)",
            "INSERT INTO product (name, description, price, stock, user_id) VALUES ('$name', '$description', $price, $stock, $userId)",
            "INSERT INTO product (name, description, price, stock) VALUES ('$name', '$description', $price, $stock)"
        ];

        foreach($queries as $q){
            try {
                if($db->query($q)){
                    break;
                }
            } catch (mysqli_sql_exception $e) {
                continue;
            }
        }
    }

    header("Location: index.php");
    exit;
}
?>