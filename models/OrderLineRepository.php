<?php
    class OrderLineRepository{
        public static function getOrderLinesByOrderId($order_id){
            $db = DB::connect();
            $query = "SELECT * FROM order_lines WHERE order_id = $order_id";
            $result = $db->query($query);
            $orderLines = [];
            while($row = $result->fetch_assoc()){
                $orderLines[] = new OrderLine($row['id'], $row['product_id'], $row['quantity'],
                $row['price'], $row['order_id']);
            }
            return $orderLines;
        }

        public static function getOrderLineById($id){
            $db = DB::connect();
            $query = "SELECT * FROM order_lines WHERE id = $id";
            $result = $db->query($query);
            $orderLine = $result->fetch_assoc();
            
            if(!$orderLine) return null;

            return new OrderLine($orderLine['id'], $orderLine['product_id'], $orderLine['quantity'],
            $orderLine['price'], $orderLine['order_id']);
        }

        public static function addOrderLineToOrder($order, $product, $quantity){
            $db = DB::connect();
            $orderId = $order->getId();
            $productId = $product->getId();
            $price = $product->getPrice();

            // Comprobamos si el producto ya está en las líneas de este pedido
            $check = $db->query("SELECT * FROM order_lines WHERE order_id = $orderId AND product_id = $productId");
            
            if($row = $check->fetch_assoc()){
                // Si ya existe, sumamos la cantidad (stock) a la línea existente
                $nuevaCantidad = $row['quantity'] + $quantity;
                $db->query("UPDATE order_lines SET quantity = $nuevaCantidad WHERE id = " . $row['id']);
                $success = true;
            } else {
                // Si no existe, creamos la nueva línea de pedido
                $q = "INSERT INTO order_lines (order_id, product_id, quantity, price) VALUES ($orderId, $productId, $quantity, $price)";
                $db->query($q);
                $success = $db->insert_id ? true : false;
            }

            // Opcional pero recomendado: Actualizar el total_price del pedido
            $totalResult = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = $orderId");
            if($tRow = $totalResult->fetch_assoc()){
                $nuevoTotal = $tRow['total'] ? $tRow['total'] : 0;
                $db->query("UPDATE orders SET total_price = $nuevoTotal WHERE id = $orderId");
            }

            return $success;
        }

        public static function removeOrderLine($lineId, $order) {
            $db = DB::connect();
            $query = "SELECT * FROM order_lines WHERE id = " . intval($lineId) . " AND order_id = " . intval($order->getId());
            $result = $db->query($query);
            
            if($row = $result->fetch_assoc()){
                $subtotal = $row['price'] * $row['quantity'];
                $db->query("DELETE FROM order_lines WHERE id = " . intval($lineId));
                
                $newTotal = $order->getTotal() - $subtotal;
                if($newTotal < 0) $newTotal = 0;
                
                $db->query("UPDATE orders SET total_price = " . $newTotal . " WHERE id = " . $order->getId());
            }
        }
    }
?>