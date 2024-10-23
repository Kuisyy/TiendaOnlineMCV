<?php
session_start();
require_once("models/user.php");
require_once("models/userRepository.php");

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = userRepository::login($username,$password);
    if($user){
        $_SESSION['username'] = $user->getUsername();
    }
    else{
        $error = "Invalid credentials";
        header("Location: index.php?error=".$error);
    }
}


?>