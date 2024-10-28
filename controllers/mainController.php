<?php
session_start();

require_once("models/user.php");
require_once("models/userRepository.php");

if(isset($_GET['logout'])){
    userRepository::logout();
    exit();
}

if(isset($_SESSION['username'])){
    require_once("views/logoutView.phtml");
    require_once("views/mainView.phtml");

}else{
    require_once("controllers/loginController.php");
    require_once("views/loginView.phtml");

}

?>
