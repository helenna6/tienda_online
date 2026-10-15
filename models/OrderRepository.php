<?php
    class OrderRepository{
        public static function getOrderById($id){
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM ORDERS WHERE order_id = ".$id;
            $result = $db->query($query);
            $order = $result ? $result->fetch_assoc() : null;
            if(!$order) return null;
            $orderId = $order['order_id'];
            $buyerId = $order['user_id'];
            $total = 0;
            return new Order($orderId, $buyerId, $total, $order['date'], $order['status']);
        }

        public static function getCarritoByUserId($id){
            $db = DB::connect();
            $id = intval($id);
            $q = "SELECT * FROM ORDERS WHERE status = 'Pending' AND user_id = ".$id;
            $result = $db->query($q);
            if($result && $row = $result->fetch_assoc()){
                $orderId = $row['order_id'];
                $buyerId = $row['user_id'];
                $total = 0;
                return new Order($orderId, $buyerId, $total, $row['date'], $row['status']);
            }
            $fechaActual = date('Y-m-d H:i:s');
            $q = "INSERT INTO ORDERS (user_id, date, status) VALUES (".$id.", '".$fechaActual."', 'Pending')";
            $db->query($q);
            $newOrderId = $db->insert_id;
            return new Order($newOrderId, $id, 0, $fechaActual, 'Pending');
        }
    }
?>