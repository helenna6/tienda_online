<?php   
//cargar modelos
require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/Product.php");
require_once("models/User.php");
require_once("repositories/OrderRepository.php");
require_once("repositories/OrderLineRepository.php");
require_once("repositories/ProductRepository.php");
require_once("repositories/UserRepository.php");

session_start();

if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
    exit;
}   


//acciones

//listar productos
function listProducts(){
    $productRepository = new ProductRepository();
    $products = $productRepository->getAllProducts();
    require_once("views/listProducts.php");
}

//login


//ver login 
if(isset($_GET['login'])){
    require_once("views/login.phtml");
    exit;
}

//logout
if(isset($_GET['logout'])){
    require_once("views/logout.phtml");
    exit;   
}

//register

if(isset($_GET['register'])){
    require_once("views/register.phtml");
    exit;
}

//añadir al carrito

//terminar pedido

//vista por defecto






?>