<?php

class ProductRepository{

    public static function getProducts(){

        $products = [];

        $conn = db::connect();

        $result = $conn->query("SELECT * FROM PRODUCT");

        while ($row = $result->fetch_assoc()) {

            $products[] = new Product(
                $row['product_id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock']
            );
        }

        return $products;
    }


    public static function getProductById($id){

        $db = DB::connect();

        $query = "SELECT * FROM PRODUCT WHERE product_id=".$id;

        $result = $db->query($query);

        $product = $result->fetch_assoc();

        return new Product(
            $product['product_id'],
            $product['name'],
            $product['description'],
            $product['price'],
            $product['stock']
        );
    }
}
?>