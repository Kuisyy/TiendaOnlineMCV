<?php
require_once("models/user.php");
require_once("models/userRepository.php");
require_once("controllers/productController.php");

session_start();


if (isset($_GET['logout'])) {
    userRepository::logout();
    exit();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']; 
    require_once("views/logoutView.phtml");

    if ($user->getRol() == 1) {
        require_once("views/addProducts.phtml");
    }
} else {
    require_once("controllers/loginController.php");
    require_once("views/loginView.phtml");
}

// Cargamos la vista principal al final
require_once("views/mainView.phtml");
?>
