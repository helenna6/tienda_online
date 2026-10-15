<?php
    if(isset($_GET['add']) || (isset($_GET['action']) && $_GET['action'] == 'add')){
        $productId = $_POST['id'] ?? ($_POST['product_id'] ?? null);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        if($productId && isset($_SESSION['user'])){
            $product = ProductRepository::getProductById($productId);
            if($product){
                $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
                OrderLineRepository::addOrderLineToOrder($order, $product, $quantity);
                header('location: index.php?added=1');
                exit;
            }
        }
        header('location: index.php');
        exit;
    }

    if(isset($_GET['update'])){
        if(isset($_POST['id']) && isset($_POST['quantity'])){
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];
            OrderLineRepository::updateQuantity($id, $quantity);
        }
        header('location: index.php?c=order&show');
        exit;
    }

    if(isset($_GET['delete'])){
        if(isset($_GET['id'])){
            OrderLineRepository::deleteOrderLine($_GET['id']);
        }
        header('location: index.php?c=order&show');
        exit;
    }

    if(isset($_GET['checkout'])){
        if(isset($_SESSION['user'])){
            $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
            if(count($order->getOrderLines()) > 0){
                $db = DB::connect();
                $q = "UPDATE ORDERS SET status='Completed' WHERE order_id=".$order->getId();
                if($db->query($q)){
                    header('Location: index.php?c=order&show&success=1');
                    exit;
                }
            }
        }
        header('Location: index.php?c=order&show');
        exit;
    }

    if(isset($_GET['show']) || (isset($_GET['action']) && $_GET['action'] == 'carrito')){
        if(isset($_SESSION['user'])){
            $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
            require_once('views/showOrderView.phtml');
            exit;
        } else {
            header('Location: index.php?login');
            exit;
        }
    }
?>