<?php
require_once("models/LineaPedido.php");

class LineaPedidoRepository {

    public static function añadirLinea($id_pedido, $id_producto, $cantidad, $precio_unitario) {
        $db = Conectar::conexion();        
        $precio_total = $cantidad * $precio_unitario;
        $query = "INSERT INTO lineapedido (id_pedido, id_product, cantidad, precio) 
                  VALUES ('$id_pedido', '$id_producto', '$cantidad', '$precio_total')";
        $db->query($query);
    }

    public static function getLineasByPedido($id_pedido) {
        $db = Conectar::conexion();
        $query = "SELECT * FROM lineapedido WHERE id_pedido = '$id_pedido'";
        $result = $db->query($query);

        $lineas = [];
        while ($row = $result->fetch_assoc()) {
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
