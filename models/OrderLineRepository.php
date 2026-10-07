<?php
    class OrderLineRepository {
        public static function getOrderLinesByOrderId($order_id){
            $db = DB::connect();
            $query = "SELECT * FROM order_lines WHERE order_id = $order_id";
            $order_lines = $db->query($query);
            return $order_lines;
        }
        public static function createOrderLine($order_id, $product_id, $quantity, $price){
            $db = DB::connect();
            $query = "INSERT INTO order_lines (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
            $db->query($query);
        }
        public static function updateOrderLine($id, $order_id, $product_id, $quantity, $price){
            $db = DB::connect();
            $query = "UPDATE order_lines SET order_id = $order_id, product_id = $product_id, quantity = $quantity, price = $price WHERE id = $id";
            $db->query($query);
        }
        public static function deleteOrderLine($id){
            $db = DB::connect();
            $query = "DELETE FROM order_lines WHERE id = $id";
            $db->query($query);
        }
    }
?>