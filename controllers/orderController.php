<?php
    if(isset($_GET['add'])){
        if(isset($_POST['id']) && isset($_POST['quantity'])){
            $product = ProductRepository::getProductById($_POST['id']);
            $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
            if(OrderLineRepository::addOrderLineToOrder($order, $product, $_POST['quantity'])){
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
    if(isset($_GET['checkout'])){
        $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
        if(count($order->getOrderLines()) > 0){
            $db = DB::connect();
            $q = "UPDATE ORDERS SET status='Completed' WHERE order_id=".$order->getId();
            if($db->query($q)){
                header('Location: index.php?c=order&show&success=1');
                exit;
            }
        }
        header('Location: index.php?c=order&show');
        exit;
    }
    if(isset($_GET['show'])){
        $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
        require_once('views/showOrderView.phtml');
        exit;
    }
?>