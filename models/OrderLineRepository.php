<?php
    class OrderLineRepository{
        public static function getOrderLinesByOrderId($order_id){
            $db = DB::connect();
            $order_id = intval($order_id);
            $query = "SELECT * FROM ORDER_LINE WHERE order_id = $order_id";
            $result = $db->query($query);
            $orderLines = [];
            if($result){
                while($row = $result->fetch_assoc()){
                    $lineId = $row['order_line_id'];
                    $price = $row['unit_price'];
                    $orderLines[] = new OrderLine($lineId, $row['product_id'], $row['quantity'], $price, $row['order_id']);
                }
            }
            return $orderLines;
        }
        public static function getOrderLineById($id){
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM ORDER_LINE WHERE order_line_id = $id";
            $result = $db->query($query);
            if($result && $orderLine = $result->fetch_assoc()){
                $lineId = $orderLine['order_line_id'];
                $price = $orderLine['unit_price'];
                return new OrderLine($lineId, $orderLine['product_id'], $orderLine['quantity'], $price, $orderLine['order_id']);
            }
            return null;
        }
        public static function addOrderLineToOrder($order, $product, $quantity){
            $db = DB::connect();
            $orderId = intval($order->getId());
            $productId = intval($product->getId());
            $price = floatval($product->getPrice());
            $quantity = intval($quantity);
            $check = $db->query("SELECT * FROM ORDER_LINE WHERE order_id = $orderId AND product_id = $productId");
            if($check && $row = $check->fetch_assoc()){
                $nuevaCantidad = $row['quantity'] + $quantity;
                $lineId = $row['order_line_id'];
                $db->query("UPDATE ORDER_LINE SET quantity = $nuevaCantidad WHERE order_line_id = " . intval($lineId));
                $success = true;
            } else {
                $q = "INSERT INTO ORDER_LINE (order_id, product_id, quantity, unit_price) VALUES ($orderId, $productId, $quantity, $price)";
                $db->query($q);
                $success = $db->insert_id ? true : false;
            }
            return $success;
        }
        public static function updateQuantity($id, $quantity){
            $db = DB::connect();
            $id = intval($id);
            $quantity = intval($quantity);
            if($quantity <= 0){
                return self::deleteOrderLine($id);
            }
            $q = "UPDATE ORDER_LINE SET quantity = $quantity WHERE order_line_id = $id";
            $db->query($q);

            return true;
        }
        public static function deleteOrderLine($id){
            $db = DB::connect();
            $id = intval($id);
            $q = "DELETE FROM ORDER_LINE WHERE order_line_id = $id";
            $db->query($q);
            return true;
        }
        public static function removeOrderLine($lineId, $order) {
            return self::deleteOrderLine($lineId);
        }
    }
?>