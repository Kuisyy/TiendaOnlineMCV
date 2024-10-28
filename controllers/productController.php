<?php
require_once("models/user.php");
require_once("models/product.php");
require_once("models/productsRepository.php");

$products = productsRepository::getAllProducts();

if(isset($_POST['addProduct'])){
    $price = $_POST['price'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    productsRepository::addProduct($price,$name,$description,$stock);
    header('Location:index.php');
    exit();
}


?>