<?php 

    class ProductRepository{
        
        public function getProductsByCategoryId($category_id){
            $products = [];
            $conn = $this->connectDB();
            $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
            $products[] =;
            while($row = $stmt->fetch_assoc()){
                $products[] = new Product($row['product_id'], $row['name'], $row['description'], $row['price'], $row['stock'], $row['supplier_id'], $row['category_id'], $row['image']);
            }
            return $products;
        }
        public function getProductById($product_id){
            $conn = $this->connectDB();
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Product($row['product_id'], $row['name'], $row['description'], $row['price'], $row['stock'], $row['supplier_id'], $row['category_id'], $row['image']);
        }

    }