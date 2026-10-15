<?php
    class OrderRepository{
        public static function getOrderById($id){
            $db = DB::connect();
            $query = "SELECT * FROM orders WHERE id = ".$id;
            $result = $db->query($query);
            $order = $result->fetch_assoc();
            
            if(!$order) return null;

            return new Order($order['id'], $order['buyer_id'], $order['total_price'], $order['date'], $order['status']);
        }
        
        public static function getCarritoByUserId($id){
            $db = DB::connect();
            
            // Buscamos el carrito abierto (status = 0) usando buyer_id
            $q = "SELECT * FROM orders WHERE status = 0 AND buyer_id = ".$id;
            $result = $db->query($q);
            
            if($row = $result->fetch_assoc()){
                return new Order($row['id'], $row['buyer_id'], $row['total_price'], $row['date'], $row['status']);
            }
            
            // Si no tiene carrito abierto, creamos uno nuevo
            $fechaActual = date('Y-m-d H:i:s');
            $q = "INSERT INTO orders (buyer_id, total_price, date, status) VALUES (".$id.", 0, '".$fechaActual."', 0)";
            $db->query($q);
            
            $newOrderId = $db->insert_id;
            
            return new Order($newOrderId, $id, 0, $fechaActual, 0);
        }
    }
?>