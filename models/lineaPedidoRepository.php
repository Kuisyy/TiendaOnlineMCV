<?php
require_once("models/LineaPedido.php");

class LineaPedidoRepository {

    public static function añadirLinea($id_pedido, $id_producto, $precio_unitario) {
        $db = Conectar::conexion();
    
        // Verificar si el producto ya está en la línea de pedido
        $query = "SELECT cantidad FROM lineapedido WHERE id_pedido = '$id_pedido' AND id_product = '$id_producto'";
        $result = $db->query($query);
    
        if ($result->num_rows > 0) {
            // Si existe, incrementar la cantidad en 1
            $row = $result->fetch_assoc();
            $nuevaCantidad = $row['cantidad'] + 1;
            $nuevoPrecioTotal = $nuevaCantidad * $precio_unitario;
            
            $updateQuery = "UPDATE lineapedido 
                            SET cantidad = '$nuevaCantidad', precio = '$nuevoPrecioTotal' 
                            WHERE id_pedido = '$id_pedido' AND id_product = '$id_producto'";
            $db->query($updateQuery);
        } else {
            // Si no existe, añadir una nueva línea de pedido con cantidad 1
            $cantidad = 1;
            $precio_total = $cantidad * $precio_unitario;
            $insertQuery = "INSERT INTO lineapedido (id_pedido, id_product, cantidad, precio) 
                            VALUES ('$id_pedido', '$id_producto', '$cantidad', '$precio_total')";
            $db->query($insertQuery);
        }
    }
    

    public static function getLineasByPedido($id_pedido) {
        $db = Conectar::conexion();
        $query = "SELECT * FROM lineapedido WHERE id_pedido = '$id_pedido'";
        $result = $db->query($query);
    
        $lineas = [];
        while ($row = $result->fetch_assoc()) {
            // Aquí estamos creando un objeto LineaPedido para cada fila y almacenándolo en el array $lineas
            $lineas[] = new LineaPedido($row);
        }
        return $lineas;
    }
    
    
    public static function eliminarLinea($num_linea) {
        $db = Conectar::conexion();
        $query = "DELETE FROM lineapedido WHERE num_linea = '$num_linea'";
        $db->query($query);
    }
}
?>
