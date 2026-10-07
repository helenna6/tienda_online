<?php

class ProductRepository {

    public static function getProducts() {
        $products = [];
        $conn = db::connect();

        $result = $conn->query("SELECT * FROM PRODUCT");

        while ($row = $result->fetch_assoc()) {
            $products[] = new Product(
                $row['product_id'],
                $row['description'],
                $row['price'],
                $row['stock']
            );
        }

        return $products;
    }

    public static function getProductById($product_id) {
        $conn = db::connect();

        $stmt = $conn->prepare(
            "SELECT * FROM PRODUCT WHERE product_id = ?"
        );

        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            return null;
        }

        return new Product(
            $row['product_id'],
            $row['description'],
            $row['price'],
            $row['stock']
        );
    }
}