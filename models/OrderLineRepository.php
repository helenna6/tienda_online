<?php
    class OrderLineRepository{
        public static function getOrderLinesByOrderId($order_id){
            $db = DB::connect();
            $order_id = intval($order_id);
            $query = "SELECT * FROM order_lines WHERE order_id = $order_id";
            $result = $db->query($query);
            $orderLines = [];
            if($result){
                while($row = $result->fetch_assoc()){
                    $lineId = $row['id'] ?? ($row['order_line_id'] ?? null);
                    $price = $row['price'] ?? ($row['unit_price'] ?? 0);
                    $orderLines[] = new OrderLine($lineId, $row['product_id'], $row['quantity'], $price, $row['order_id']);
                }
            }
            return $orderLines;
        }

        public static function getOrderLineById($id){
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM order_lines WHERE id = $id";
            $result = $db->query($query);
            if($result && $orderLine = $result->fetch_assoc()){
                $lineId = $orderLine['id'] ?? ($orderLine['order_line_id'] ?? null);
                $price = $orderLine['price'] ?? ($orderLine['unit_price'] ?? 0);
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

            // Comprobamos si el producto ya está en las líneas de este pedido
            $check = $db->query("SELECT * FROM order_lines WHERE order_id = $orderId AND product_id = $productId");
            
            if($check && $row = $check->fetch_assoc()){
                // Si ya existe, sumamos la cantidad a la línea existente
                $nuevaCantidad = $row['quantity'] + $quantity;
                $lineId = $row['id'] ?? $row['order_line_id'];
                $db->query("UPDATE order_lines SET quantity = $nuevaCantidad WHERE id = " . intval($lineId));
                $success = true;
            } else {
                // Si no existe, creamos la nueva línea de pedido
                $q = "INSERT INTO order_lines (order_id, product_id, quantity, price) VALUES ($orderId, $productId, $quantity, $price)";
                $db->query($q);
                $success = $db->insert_id ? true : false;
            }

            // Actualizar total_price del pedido
            $totalResult = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = $orderId");
            if($totalResult && $tRow = $totalResult->fetch_assoc()){
                $nuevoTotal = $tRow['total'] ? $tRow['total'] : 0;
                $db->query("UPDATE orders SET total_price = $nuevoTotal WHERE id = $orderId");
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

            // Obtener order_id para recalcular total
            $res = $db->query("SELECT order_id FROM order_lines WHERE id = $id");
            $orderId = ($res && $r = $res->fetch_assoc()) ? $r['order_id'] : null;

            $q = "UPDATE order_lines SET quantity = $quantity WHERE id = $id";
            $db->query($q);

            if($orderId){
                $totalResult = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = " . intval($orderId));
                if($totalResult && $tRow = $totalResult->fetch_assoc()){
                    $nuevoTotal = $tRow['total'] ? $tRow['total'] : 0;
                    $db->query("UPDATE orders SET total_price = $nuevoTotal WHERE id = " . intval($orderId));
                }
            }
            return true;
        }

        public static function deleteOrderLine($id){
            $db = DB::connect();
            $id = intval($id);

            // Obtener order_id para recalcular total
            $res = $db->query("SELECT order_id FROM order_lines WHERE id = $id");
            $orderId = ($res && $r = $res->fetch_assoc()) ? $r['order_id'] : null;

            $q = "DELETE FROM order_lines WHERE id = $id";
            $db->query($q);

            if($orderId){
                $totalResult = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = " . intval($orderId));
                if($totalResult && $tRow = $totalResult->fetch_assoc()){
                    $nuevoTotal = $tRow['total'] ? $tRow['total'] : 0;
                    $db->query("UPDATE orders SET total_price = $nuevoTotal WHERE id = " . intval($orderId));
                }
            }
            return true;
        }

        public static function removeOrderLine($lineId, $order) {
            return self::deleteOrderLine($lineId);
        }
    }
?>