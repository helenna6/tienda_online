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

    // Obtener productos
    $allProducts = ProductRepository::getProducts();

    // Obtener pedidos
    $ordersResult = $db->query("SELECT * FROM orders");
    $allOrders = [];
    if($ordersResult){
        while($row = $ordersResult->fetch_assoc()){
            $orderId = $row['id'] ?? ($row['order_id'] ?? null);
            $buyerId = $row['buyer_id'] ?? ($row['user_id'] ?? null);
            $total = $row['total_price'] ?? 0;
            $allOrders[] = new Order($orderId, $buyerId, $total, $row['date'], $row['status']);
        }
    }

    // Obtener usuarios
    $usersResult = $db->query("SELECT * FROM users");
    $allUsers = [];
    if($usersResult){
        while($row = $usersResult->fetch_assoc()){
            $userId = $row['id'] ?? ($row['user_id'] ?? null);
            $username = $row['username'] ?? ($row['name'] ?? '');
            $rol = $row['rol'] ?? 'usuario';
            $allUsers[] = new User($userId, $username, $rol);
        }
    }

    require_once('views/adminView.phtml');
    exit;
?>