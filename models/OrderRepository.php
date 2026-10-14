<?php
    class OrderRepository{
        public static function getOrderById($id){
            $db = DB::connect();
            $query = "SELECT * FROM ORDERS WHERE order_id=".$id;
            $result = $db->query($query);
            $order = $result->fetch_assoc();
            return new Order($order['order_id'],$order['user_id'],0,$order['date'],$order['status']);
        }
        public static function getCarritoByUserId($id){
            $db = DB::connect();
            $q = "SELECT * FROM ORDERS WHERE status='Pending' AND user_id=".$id;
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                return new Order($row['order_id'],$row['user_id'],0,$row['date'],$row['status']);
            }
            $q = "INSERT INTO ORDERS (user_id, status) VALUES (".$id.", 'Pending')";
            $db->query($q);
            $order_id = $db->insert_id;
            return new Order($order_id,$id,0,date('Y-m-d H:i:s'),'Pending');
        }
    }
?>