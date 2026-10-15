<?php
    class ProductRepository{
        public static function getProducts(){
            $products = [];
            $conn = DB::connect();
            $result = null;
            try {
                $result = $conn->query("SELECT * FROM products");
            } catch (mysqli_sql_exception $e) {
                try {
                    $result = $conn->query("SELECT * FROM product");
                } catch (mysqli_sql_exception $e2) {
                    $result = null;
                }
            }
            if($result){
                while ($row = $result->fetch_assoc()) {
                    $pid = $row['id'] ?? ($row['product_id'] ?? null);
                    $name = $row['name'] ?? '';
                    $desc = $row['description'] ?? '';
                    $price = $row['price'] ?? 0;
                    $stock = $row['stock'] ?? 0;
                    $createdAt = $row['created_at'] ?? date('Y-m-d H:i:s');
                    $products[] = new Product($pid, $name, $desc, $price, $stock, $createdAt);
                }
            }
            return $products;
        }

        public static function getProductsByUserId($user_id){
            $products = [];
            if(!$user_id) {
                return $products;
            }
            $conn = DB::connect();
            $result = null;
            try {
                $result = $conn->query("SELECT * FROM products WHERE user_id=".$user_id);
            } catch (mysqli_sql_exception $e) {
                try {
                    $result = $conn->query("SELECT * FROM product WHERE user_id=".$user_id);
                } catch (mysqli_sql_exception $e2) {
                    return self::getProducts();
                }
            }
            if(!$result){
                return self::getProducts();
            }
            while($row = $result->fetch_assoc()){
                $pid = $row['id'] ?? ($row['product_id'] ?? null);
                $name = $row['name'] ?? '';
                $desc = $row['description'] ?? '';
                $price = $row['price'] ?? 0;
                $stock = $row['stock'] ?? 0;
                $createdAt = $row['created_at'] ?? date('Y-m-d H:i:s');
                $products[] = new Product($pid, $name, $desc, $price, $stock, $createdAt);
            }
            return $products;
        }

        public static function getProductById($id){
            $db = DB::connect();
            $id = intval($id);
            $result = null;
            $queries = [
                "SELECT * FROM products WHERE id=".$id,
                "SELECT * FROM product WHERE product_id=".$id,
                "SELECT * FROM products WHERE product_id=".$id,
                "SELECT * FROM product WHERE id=".$id
            ];
            foreach($queries as $q){
                try {
                    $res = $db->query($q);
                    if($res && $res->num_rows > 0){
                        $result = $res;
                        break;
                    }
                } catch (mysqli_sql_exception $e) {
                    continue;
                }
            }
            if($result && $product = $result->fetch_assoc()){
                $pid = $product['id'] ?? ($product['product_id'] ?? $id);
                $name = $product['name'] ?? '';
                $desc = $product['description'] ?? '';
                $price = $product['price'] ?? 0;
                $stock = $product['stock'] ?? 0;
                $createdAt = $product['created_at'] ?? date('Y-m-d H:i:s');
                return new Product($pid, $name, $desc, $price, $stock, $createdAt);
            }
            return null;
        }
    }
?>