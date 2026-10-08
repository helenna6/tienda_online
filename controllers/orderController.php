<?php
    if(isset($_GET['add'])){
        // sacar el producto de la base de datos
       if(isset($_POST['product_id'])){
        $product=ProductRepository::getProductById($_POST['product_id']);
       // tener el pedido en estado carrito del usuario
        $order=OrderRepository::getOrderByUserId($_SESSION['user']->getId());
       // crear un orderline en pedido de usuario con producto
       // devolviendo a la vista del carrito
       }
    }
?>