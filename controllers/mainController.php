<?php
require_once("models/user.php");
require_once("models/userRepository.php");
require_once("controllers/productController.php");


if (isset($_GET['logout'])) {
    userRepository::logout();
    exit();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']; 
    require_once("views/logoutView.phtml");
    require_once("views/mainView.phtml");

    if ($user->getRol() == 1) {
        require_once("views/crudProducts.phtml");
    }
} else {
    require_once("controllers/loginController.php");
    require_once("views/loginView.phtml");
}

?>
