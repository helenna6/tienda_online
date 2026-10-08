<?php
    require_once("models/User.php");
    require_once("models/Product.php");
    require_once("models/Order.php");
    require_once("models/OrderLine.php");
    require_once("models/ProductRepository.php");
    require_once("models/OrderRepository.php");
    require_once("models/OrderLineRepository.php");
    require_once("models/UserRepository.php");

    session_start();

    if(isset($_GET['c'])){
        require_once("controllers/".$_GET['c']."Controller.php");
    }
    if(isset($_GET['login'])){
        require_once('views/login.phtml');
        exit;
    }
    if(isset($_GET['register'])){
        require_once('views/register.phtml');
        exit;
    }
    if(isset($_SESSION['user'])){
        $products = ProductRepository::getProductsByUserId($_SESSION['user']->getId());
    }else{
        $products = [];
    }
    require_once("views/mainView.phtml");
?>