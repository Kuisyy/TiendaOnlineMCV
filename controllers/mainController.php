<?php
require_once("models/user.php");
require_once("models/userRepository.php");
require_once("controllers/productController.php");
require_once("controllers/lpController.php"); // Si tienes un controlador específico para pedidos


if (isset($_GET['logout'])) {
    UserRepository::logout();
    header("Location: index.php"); 
    exit();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    
    $products = ProductsRepository::getAllProducts(); 

    if ($user->getRol() == 1) {
        require_once("views/crudProducts.phtml");
    }

    require_once("views/mainView.phtml");
    
    if (isset($_GET['verPedido'])) {
        $pedido = PedidoRepository::getActivePedido($user->getId());
        require_once("views/pedidoView.phtml");
    }
} else {
    // Si no hay usuario en sesión, carga el controlador de login
    require_once("controllers/loginController.php");
    require_once("views/loginView.phtml");
}

?>
