<?php

// Cargar modelos
require_once("models/User.php");
require_once("models/Product.php");
require_once("models/Order.php");
require_once("models/OrderLine.php");

// Cargar repositorios
require_once("repositories/ProductRepository.php");
require_once("repositories/OrderRepository.php");
require_once("repositories/UserRepository.php");
require_once("repositories/OrderLineRepository.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enrutador de controladores específicos
if(isset($_GET['c'])){
    $controller = strtolower($_GET['c']);
    $controllerFile = "controllers/" . $controller . "Controller.php";
    if(file_exists($controllerFile)){
        require_once($controllerFile);
        exit;
    }
}

// Rutas de autenticación y vistas
if(isset($_GET['login'])){
    require_once("views/login.phtml");
    exit;
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

if(isset($_GET['register'])){
    require_once("views/register.phtml");
    exit;
}

// Vista por defecto: listar productos
$products = ProductRepository::getProducts();
require_once("views/mainView.phtml");
?>