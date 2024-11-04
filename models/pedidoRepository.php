<?php
require_once("models/pedido.php");
require_once("db.php");

class PedidoRepository {
    public static function createPedido($id_usr) {
        $conexion = Conectar::conexion();
        $nombre = "Pedido de " . date('Y-m-d H:i:s'); // Un nombre único para el pedido
        $sql = "INSERT INTO pedido (id_usr, nombre, fecha, estado, precioTotal) VALUES ($id_usr, '$nombre', NOW(), 'En Proceso', 0)";
        $conexion->query($sql);
        return $conexion->insert_id; // Retorna el ID del pedido creado
    }

    public static function getActivePedido($id_usr) {
        $conexion = Conectar::conexion();
        $sql = "SELECT * FROM pedido WHERE id_usr = $id_usr AND estado = 'En Proceso'";
        $result = $conexion->query($sql);
        return $result->fetch_object('Pedido');
    }

    public static function addLineToPedido($id_pedido, $id_product, $cantidad, $precio) {
        $conexion = Conectar::conexion();
        $sql = "INSERT INTO lineapedido (id_pedido, id_product, cantidad, precio) VALUES ($id_pedido, $id_product, $cantidad, $precio)";
        $conexion->query($sql);
    }

    public static function finalizePedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "UPDATE pedido SET estado = 'Finalizado' WHERE id_pedido = $id_pedido";
        $conexion->query($sql);
    }

    public static function getLineasByPedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "SELECT lp.*, p.name, p.price FROM lineapedido lp JOIN products p ON lp.id_product = p.id_product WHERE lp.id_pedido = $id_pedido";
        $result = $conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
