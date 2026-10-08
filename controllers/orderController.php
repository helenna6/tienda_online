<?php
    if(isset($_GET['add'])){
        // sacar el producto de la base de datos
       if(isset($_POST['product_id'])){
        $product=ProductRepository::getProductById($_POST['product_id']);
       // tener el pedido en estado carrito del usuario
       $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
       // crear un orderline en pedido de usuario con producto
       }
       if(OrderRepository::addOrderLineToOrder($order, $product, $_POST['quantity'])){
        header('location:index.php?c=order&show');
        exit;
       }
       // devolviendo a la vista del carrito
       header('location:index.php');
       exit;
       }
       if(isset($_GET['show'])){
        require_once'views/showOrderView.phtml';
        exit;
       }
?>