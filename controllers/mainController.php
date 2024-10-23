<?php
session_start();
require_once("models/user.php");
require_once("models/userRepository.php");

if (!isset($_SESSION['username'])) {
    require_once("views/loginView.phtml");
} else {
    require_once("views/mainView.phtml");
    require_once("views/logoutView.phtml");
    
    if (isset($_GET['logout'])) {
        userRepository::logout();  
        exit();  
    }
}
?>
