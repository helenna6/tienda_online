<?php
    if(!isset($_SESSION['user'])){
        header('location: index.php');
        exit;
    }
    $rolUsuario = strtolower(trim($_SESSION['user']->getRol()));
    if($rolUsuario != 'admin' && $rolUsuario != 'administrador' && $rolUsuario != '1'){
        header('location: index.php');
        exit;
    }
    $db = DB::connect();
    $allProducts = ProductRepository::getProducts();
    $ordersResult = $db->query("SELECT * FROM ORDERS");
    $allOrders = [];
    if($ordersResult){
        while($row = $ordersResult->fetch_assoc()){
            $orderId = $row['order_id'];
            $buyerId = $row['user_id'];
            $total = 0;
            $allOrders[] = new Order($orderId, $buyerId, $total, $row['date'], $row['status']);
        }
    }
    $usersResult = $db->query("SELECT * FROM USERS");
    $allUsers = [];
    if($usersResult){
        while($row = $usersResult->fetch_assoc()){
            $userId = $row['user_id'];
            $username = $row['name'];
            $rol = $row['rol'] ?? 'user';
            $allUsers[] = new User($userId, $username, $rol);
        }
    }
    require_once('views/adminView.phtml');
    exit;
?>