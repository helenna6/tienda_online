<?php
    class OrderRepository {
        public static function getOrdersByUserId($user_id){
            $db = DB::connect();
            $query = "SELECT * FROM orders WHERE user_id = $user_id";
            $result=$db->query($query);
            $order=$result->fetch_assoc();
            return new Order($order['id'],$order['user_id'],$order['total_price'], $order['date'],$order['status']);
        }
        public static function createOrder($user_id, $total_price){
            $db = DB::connect();
            $query = "INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total_price)";
            $db->query($query);
        }
        public static function updateOrder($id, $user_id, $total_price){
            $db = DB::connect();
            $query = "UPDATE orders SET user_id = $user_id, total_price = $total_price WHERE id = $id";
            $db->query($query);
        }
        public static function deleteOrder($id){
            $db = DB::connect();
            $query = "DELETE FROM orders WHERE id = $id";
            $db->query($query);
        }
    }
?>