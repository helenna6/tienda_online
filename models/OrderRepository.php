<?php
    class OrderRepository{
        public static function getOrderById($id){
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM orders WHERE id = ".$id;
            $result = $db->query($query);
            $order = $result ? $result->fetch_assoc() : null;
            
            if(!$order) return null;

            $orderId = $order['id'] ?? ($order['order_id'] ?? $id);
            $buyerId = $order['buyer_id'] ?? ($order['user_id'] ?? null);
            $total = $order['total_price'] ?? 0;

            return new Order($orderId, $buyerId, $total, $order['date'], $order['status']);
        }
        
        public static function getCarritoByUserId($id){
            $db = DB::connect();
            $id = intval($id);
            
            // Buscamos el carrito abierto (status = 0 o status = 'Pending') usando buyer_id
            $q = "SELECT * FROM orders WHERE (status = '0' OR status = 'Pending') AND buyer_id = ".$id;
            $result = $db->query($q);
            
            if($result && $row = $result->fetch_assoc()){
                $orderId = $row['id'] ?? ($row['order_id'] ?? null);
                $buyerId = $row['buyer_id'] ?? ($row['user_id'] ?? $id);
                $total = $row['total_price'] ?? 0;
                return new Order($orderId, $buyerId, $total, $row['date'], $row['status']);
            }
            
            // Si no tiene carrito abierto, creamos uno nuevo
            $fechaActual = date('Y-m-d H:i:s');
            $q = "INSERT INTO orders (buyer_id, total_price, date, status) VALUES (".$id.", 0, '".$fechaActual."', 'Pending')";
            $db->query($q);
            
            $newOrderId = $db->insert_id;
            
            return new Order($newOrderId, $id, 0, $fechaActual, 'Pending');
        }
    }
?>