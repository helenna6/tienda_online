<?php

class OrderRepository{
    public static function getOrderById($id){
          $db=DB::connect();
        $query="SELECT * FROM order WHERE id=$id";
        $result=$db->query($query);
        $order=$result->fetch_assoc();
        return new Order($order['id'], $order['buyerid'], $order['total_order'], $order['order_date'], $order['status'] );
 
    }
    public static function getCarritoByUserId($id){
        if($row=$result->fetch_assoc()){
            return new Order($row['id'],$row['buyer_id'],$row['total_price'],$row['date'],
            $row['status']);
        }
        else{
            return false;
        }
    }
    public static function addOrderLineToOrder($order, $product, $quantity){
        $db=DB::connect();
        $q="INSERT INTO ORDER_LINE VALUES (null,".$order->getId().",".$product->getProductId().",
        ".$quantity.",".$product->getPrice().")";
        $db->query($q);
        if($db->insert_id){
            return true;
        }else{
            return false;
        }
    }
}