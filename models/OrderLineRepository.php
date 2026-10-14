<?php
    class OrderLineRepository{
        public static function getOrderLinesByOrderId($order_id){
            $db = DB::connect();
            $query = "SELECT * FROM ORDER_LINE WHERE order_id=".$order_id;
            $result = $db->query($query);
            $orderLines = [];
            while($row = $result->fetch_assoc()){
                $orderLines[] = new OrderLine($row['order_line_id'],$row['product_id'],$row['quantity'],
                    $row['unit_price'],$row['order_id']);
            }
            return $orderLines;
        }
        public static function getOrderLineById($id){
            $db = DB::connect();
            $query = "SELECT * FROM ORDER_LINE WHERE order_line_id=".$id;
            $result = $db->query($query);
            $orderLine = $result->fetch_assoc();
            return new OrderLine($orderLine['order_line_id'],$orderLine['product_id'],
            $orderLine['quantity'],$orderLine['unit_price'],$orderLine['order_id']);
        }
        public static function addOrderLineToOrder($order, $product, $quantity){
            $db = DB::connect();
            $q = "INSERT INTO ORDER_LINE(order_id, product_id, quantity, unit_price)VALUES
            (".$order->getId().",".$product->getId().",".$quantity.",".$product->getPrice().")";
            $db->query($q);
            if($db->insert_id){
                return true;
            }else{
                return false;
            }
        }
        public static function updateQuantity($id, $quantity){
            $db = DB::connect();
            if($quantity <= 0){
                return self::deleteOrderLine($id);
            }
            $q = "UPDATE ORDER_LINE SET quantity=".$quantity." WHERE order_line_id=".$id;
            $db->query($q);
            return true;
        }
        public static function deleteOrderLine($id){
            $db = DB::connect();
            $q = "DELETE FROM ORDER_LINE WHERE order_line_id=".$id;
            $db->query($q);
            return true;
        }
    }
?>