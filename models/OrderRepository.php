<?php
class OrderRepository{

    public function getOrdersByUser($user_id){
        $db=DB::connect();
        $query = "SELECT * FROM orders WHERE user_id = ?";
        $stmt->execute([$user_id]);
        while($row = $stmt->fetch_assoc()){
            $orders[] = new Order($row['order_id'], $row['user_id'], $row['order_date'], $row['total_amount'], $row['status']);
        }
        return $orders;
    }
    
    public function getOrderById($order_id){
        $conn = $this->connectDB();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $row = $stmt->fetch_assoc();
        return new Order($row['order_id'], $row['user_id'], $row['order_date'], $row['total_amount'], $row['status']);
    }

}
?>
