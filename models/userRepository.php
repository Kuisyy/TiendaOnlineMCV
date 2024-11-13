<?php
class userRepository {
    public static function login($username, $password) {
        $db = Conectar::conexion(); 
        // Seleccionamos las columnas específicas que necesitamos
        $q = "SELECT id_usr, username, rol FROM users WHERE username = '$username' AND password = '$password'"; 
        $result = $db->query($q);

        if ($result && $result->num_rows > 0) { // Validamos que el resultado existe y tiene filas
            $datos = $result->fetch_assoc();
            return new User($datos); // Pasamos los datos al constructor de User
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

    public static function getUsuarioQueMasHaGastado() {
        $query = "SELECT u.id_usr, u.username, SUM(p.precioTotal) AS total_gastado
                  FROM users u
                  JOIN pedido p ON u.id_usr = p.id_usr
                  GROUP BY u.id_usr
                  ORDER BY total_gastado DESC
                  LIMIT 1";
    
    $db = Conectar::conexion();
    $result = $db->query($query);
        
        $usuario = $result->fetch_assoc();
        return $usuario;
    }
    
}
?>
