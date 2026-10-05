<?php 


    class OrderLineRepository{

        public function getOrderLinesByOrderId($order_id){
            $orderLines = [];
            $conn = $this->connectDB();
            $stmt = $conn->prepare("SELECT * FROM order_lines WHERE order_id = ?");
            $stmt->execute([$order_id]);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $orderLines[] = new OrderLine($row['order_line_id'], $row['order_id'], $row['product_id'], $row['quantity'], $row['price']);
            }
            return $orderLines;
        }

    }
