<?php
class userRepository{
    public static function login($username, $password) {
        $db = Conectar::conexion(); 
        $q = "SELECT * FROM users WHERE name ='$username' AND password='$password'"; 
        $result = $db->query($q);
        if ($result->num_rows > 0) {
            $datos = $result->fetch_assoc();
            return new User($datos);
        } else {
            return false;
        }
    }
    public static function logout() {
        session_start(); 
        session_unset(); 
        session_destroy(); 
        header("Location: index.php"); 
        exit;
    }
}

?>