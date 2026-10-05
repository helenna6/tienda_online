<?php

// cargar modelos
require_once "/models/User.php";
require_once "/models/Product.php";
require_once "/models/Order.php";
require_once "/models/OrderLine.php";
require_once "/repositories/ProductRepository.php";
require_once "/repositories/OrderRepository.php";
require_once "/repositories/UserRepository.php";
require_once "/repositories/OrderLineRepository.php";

session_start();
if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
}
// acciones
    //listar productos
    //login
    if(isset($_GET['c'])){
        if($_GET['c']=='user'){
            require_once ('views/login.phtml');
            exit;
        }
    }
    if(isset($_GET['login'])){
        require_once ('views/login.phtml');
        exit;
    }
    //logout
    //register
    if(isset($_GET['register'])){
        require_once ('views/login.phtml');
        exit;
    }
    //añadir al carrito
    //terminar pedido

// vista por defecto
$products=ProductRepository::getProducts();
require_once "views/mainView.phtml";

?>