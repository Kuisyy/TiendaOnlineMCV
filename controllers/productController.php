<?php
require_once("models/user.php");
require_once("models/product.php");
require_once("models/productsRepository.php");

session_start();

$products = productsRepository::getAllProducts();

if(isset($_POST['addProduct'])){
    $id_usr= $_SESSION['user']->getId();
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    productsRepository::addProduct($id_usr,$price,$name,$description,$stock);
    header('Location: index.php'); // Redirige después de eliminar
    exit();
}

if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    productsRepository::deleteProduct($productId);
    $_SESSION['success'] = "Producto eliminado exitosamente.";
    header('Location: index.php'); // Redirige después de eliminar
    exit();
}
?>