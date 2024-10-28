<?php
require_once("models/user.php");
require_once("models/userRepository.php");

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = userRepository::login($username,$password);
    if($user){
        $_SESSION['user'] = $user;
        header('Location:index.php');
        exit();
    }
    else{
        $error = "Invalid credentials";
        header("Location: index.php?error=".$error);
        exit();
    }
}


?>