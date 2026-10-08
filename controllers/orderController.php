<?php
    if(isset($_GET['add'])){
        if(isset($_POST['id']) && isset($_POST['quantity'])){
            $product=ProductRepository::getProductById($_POST['id']);
            $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
            if(OrderLineRepository::addOrderLineToOrder($order,$product,$_POST['quantity'])){
                $newTotal= $order->getTotal()+($product->getPrice()*$_POST['quantity']);
                $db=DB::connect();
                $q="UPDATE orders SET total_price=".$newTotal." WHERE id=".$order->getId();
                $db->query($q);
                header('location: index.php?c=order&show');
                exit;
            }
        }
        header('location: index.php');
        exit; 
    }
    if(isset($_GET['show'])){
        $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
        require_once('views/showOrderView.phtml');
        exit;
    }
?>