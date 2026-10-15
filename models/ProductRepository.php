<?php
    class ProductRepository{
        public static function getProducts(){
            $products = [];
            $db = DB::connect();
            $result = $db->query("SELECT * FROM PRODUCT");
            while($row = $result->fetch_assoc()){
                $products[] = new Product($row['product_id'],$row['name'],$row['description'],
                $row['price'],$row['stock'],$row['created_at']);
            }
            return $products;
        }
        public static function getProductsByUserId($user_id){
            $products = [];
            $conn = DB::connect();
            $user_id = intval($user_id);
            $q = "SELECT * FROM PRODUCT WHERE user_id=".$user_id;
            $result = $conn->query($q);
            while($row = $result->fetch_assoc()){
                $products[] = new Product($row['product_id'],$row['name'],$row['description'],
                $row['price'],$row['stock'],$row['created_at']);
            }
            return $products;
        }
        public static function getProductById($id){
            $db = DB::connect();
            $id = intval($id);
            $q = "SELECT * FROM PRODUCT WHERE product_id=".$id;
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                return new Product($row['product_id'],$row['name'],$row['description'],$row['price'],
                $row['stock'],$row['created_at']);
            }
            return null;
        }
    }
?>