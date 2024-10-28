<?php
class productsRepository{

    public static function addProduct($price,$name,$description,$stock){
        $db = Conectar::conexion();
        $q = "INSERT INTO products (id_usr, price, name, description, stock) VALUES ('" . $_SESSION['user_id'] . "', '$price', '$name', '$description', '$stock')";
        $result = $db->query($q);
        if ($result->num_rows > 0) {
            $datos = $result->fetch_assoc();
            return new Product($datos);
        } else {
            return false;
        }
    }
    public static function getAllProducts(){
        $db = Conectar::conexion();
        $q = "SELECT * FROM products";
        $result = $db->query($q);
        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = new Product($row); 
            }
        }
        return $products;
    }
    

}
?>