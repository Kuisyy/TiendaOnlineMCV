<?php
class productsRepository{

    public static function addProduct($id_usr,$price,$name,$description,$stock){
        $db = Conectar::conexion();
        $q = "INSERT INTO products (id_usr, price, name, description, stock) VALUES ('$id_usr', '$price', '$name', '$description', '$stock')";
        $db->query($q);
    }

    public static function getAllProducts(){
        $db = Conectar::conexion();
        $q = "SELECT * FROM products";
        $result = $db->query($q);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row); 
        }
        return $products;
    }

    public static function deleteProduct($id) {
        $db = Conectar::conexion();
        $q = "DELETE FROM products WHERE id_product = '$id'";
        if (!$db->query($q)) {
            echo "Error en la consulta: " . $db->error;
        }
    }
    

}
?>