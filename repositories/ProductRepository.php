<?php

class ProductRepository {
    public static function getProducts(){
        $db = DB::connect();
        $query = "SELECT * FROM products";
        $products = $db->query($query);
        return $products;
    }

    public static function getProductById($id){
        $db = DB::connect();
        $query = "SELECT * FROM products WHERE id = $id";
        $product = $db->query($query);
        return $product;
    }

    public static function addProduct($name, $price, $stock){
        $db = DB::connect();
        $query = "INSERT INTO products (name, price, stock) VALUES ($name, $price, $stock)";
        $db->query($query);
    }

    public static function updateProduct($id, $name, $price, $stock){
        $db = DB::connect();
        $query = "UPDATE products SET name = $name, price = $price, stock = $stock WHERE id = $id";
        $db->query($query);
    }

    public static function deleteProduct($id){
        $db = DB::connect();
        $query = "DELETE FROM products WHERE id = $id";
        $db->query($query);
    }

    public static function searchProduct($name){
        $db = DB::connect();
        $query = "SELECT * FROM products WHERE name LIKE '%$name%'";
        $products = $db->query($query);
        return $products;
    }
}
?>