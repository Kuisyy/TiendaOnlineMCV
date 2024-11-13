<?php
class productsRepository {

    // Añadir un nuevo producto
    public static function addProduct($id_usr, $price, $name, $description, $stock) {
        $db = Conectar::conexion();
        $q = "INSERT INTO products (id_usr, price, name, description, stock) VALUES ('$id_usr', '$price', '$name', '$description', '$stock')";
        $db->query($q);
    }

    // Obtener todos los productos
    public static function getAllProducts() {
        $db = Conectar::conexion();
        $q = "SELECT * FROM products";
        $result = $db->query($q);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row); 
        }
        return $products;
    }

    // Eliminar un producto específico
    public static function deleteProduct($id) {
        $db = Conectar::conexion();
        $q = "DELETE FROM products WHERE id_product = '$id'";
        $db->query($q);
    }

    // Obtener un producto específico por su ID
    public static function getProductById($id) {
        $db = Conectar::conexion();
        $q = "SELECT * FROM products WHERE id_product = '$id'";
        $result = $db->query($q);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Product($row);
        }
        return null; // Si no se encuentra el producto
    }
    public static function updateProductStock($id_product, $cantidad) {
        $db = Conectar::conexion();
        $sql = "UPDATE products SET stock = stock - $cantidad WHERE id_product = $id_product";
        if ($db->query($sql) === TRUE) {
            return true; 
        } else {
            return false; 
        }
    }


    public static function getProductosMasVendidos($limit = 5) {
        // Usar el valor directamente en la consulta, sin bind_param
        $query = "SELECT p.name, p.price, SUM(lp.cantidad) AS total_comprado
                  FROM products p
                  JOIN lineapedido lp ON p.id_product = lp.id_product
                  GROUP BY p.id_product
                  ORDER BY total_comprado DESC
                  LIMIT " . (int)$limit;  // Asegúrate de castar el valor a entero
    
    $db = Conectar::conexion();
    $result = $db->query($query);
    
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        return $productos;
    }
          
}

?>
