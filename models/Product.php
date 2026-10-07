<?php
class Product {
    private $product_id;
    private $description;
    private $price;
    private $stock;

    public function __construct($product_id, $description, $price, $stock) {
        $this->product_id = $product_id;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }
}