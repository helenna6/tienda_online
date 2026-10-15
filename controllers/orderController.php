<?php
    // Si la acción es añadir un producto al carrito
    if(isset($_GET['action']) && $_GET['action'] == 'add'){
        if(isset($_POST['product_id']) && isset($_SESSION['user'])){
            $db = DB::connect();
            $userId = $_SESSION['user']->getId();
            
            // Obtenemos o creamos el carrito abierto del usuario
            $carrito = OrderRepository::getCarritoByUserId($userId);
            $orderId = $carrito->getId();
            $productId = $_POST['product_id'];
            
            // Comprobamos si el producto ya está en las líneas de este pedido
            $check = $db->query("SELECT * FROM order_lines WHERE order_id = $orderId AND product_id = $productId");
            
            if($row = $check->fetch_assoc()){
                // Si ya existe, le sumamos cantidad (stock en el pedido)
                $nuevaCantidad = $row['quantity'] + 1;
                $db->query("UPDATE order_lines SET quantity = $nuevaCantidad WHERE order_id = $orderId AND product_id = $productId");
            } else {
                // Si no existe, buscamos su precio y lo insertamos con cantidad 1
                $prodResult = $db->query("SELECT price FROM product WHERE product_id = $productId");
                if($pRow = $prodResult->fetch_assoc()){
                    $precio = $pRow['price'];
                    $db->query("INSERT INTO order_lines (order_id, product_id, quantity, price) VALUES ($orderId, $productId, 1, $precio)");
                }
            }
            
            // Recalculamos el precio total del pedido sumando todas sus líneas
            $totalResult = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = $orderId");
            if($tRow = $totalResult->fetch_assoc()){
                $nuevoTotal = $tRow['total'] ? $tRow['total'] : 0;
                $db->query("UPDATE orders SET total_price = $nuevoTotal WHERE id = $orderId");
            }
        }
        
        header('location:index.php?controller=order&action=carrito');
        exit();
    }
?>