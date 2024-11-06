<?php
require_once("models/pedido.php");
require_once("db.php");

class PedidoRepository {

    // Crear un nuevo pedido y retorna su ID
    public static function createPedido($id_usr) {
        $conexion = Conectar::conexion();
        $nombre = "Pedido de " . date('Y-m-d H:i:s'); // Nombre único para el pedido
        $sql = "INSERT INTO pedido (id_usr, nombre, fecha, estado, precioTotal) VALUES ($id_usr, '$nombre', NOW(), 'En Proceso', 0)";
        $conexion->query($sql);
        return $conexion->insert_id; // Retorna el ID del pedido creado
    }

    // Obtener el pedido activo del usuario (estado 'En Proceso')
    public static function getActivePedido($userId) {
        $db = Conectar::conexion();
        $query = "SELECT * FROM pedido WHERE id_usr = '$userId' AND estado = 'activo'";  // Ejemplo de query
        $result = $db->query($query);
    
        if ($result && $row = $result->fetch_assoc()) {
            return new Pedido($row);  // Crear un objeto Pedido pasando los datos obtenidos
        }
        return null;  // Si no se encuentra ningún pedido
    }
    

    // Añadir una línea de pedido (producto) a un pedido existente
    public static function addLineToPedido($id_pedido, $id_product, $cantidad, $precio_unitario) {
        $conexion = Conectar::conexion();
        $precio_total = $cantidad * $precio_unitario;
        $sql = "INSERT INTO lineapedido (id_pedido, id_product, cantidad, precio) VALUES ($id_pedido, $id_product, $cantidad, $precio_total)";
        $conexion->query($sql);

        // Actualizar el precio total del pedido
        self::actualizarTotalPedido($id_pedido);
    }

    // Finalizar un pedido (cambiar estado a 'Finalizado')
    public static function finalizePedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "UPDATE pedido SET estado = 'Finalizado' WHERE id_pedido = $id_pedido";
        $conexion->query($sql);
    }

    // Obtener todas las líneas de un pedido con detalles del producto
    public static function getLineasByPedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "SELECT lp.*, p.name, p.price 
                FROM lineapedido lp 
                JOIN products p ON lp.id_product = p.id_product 
                WHERE lp.id_pedido = $id_pedido";
        $result = $conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Recalcular y actualizar el total del pedido
    public static function actualizarTotalPedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "UPDATE pedido SET precioTotal = (
                    SELECT SUM(precio) FROM lineapedido WHERE id_pedido = $id_pedido
                ) WHERE id_pedido = $id_pedido";
        $conexion->query($sql);
    }

    public static function getLastFinalizedPedido($id_usr) {
        $conexion = Conectar::conexion();
        $sql = "SELECT * FROM pedido WHERE id_usr = $id_usr AND estado = 'Finalizado' ORDER BY fecha DESC LIMIT 1";
        $result = $conexion->query($sql);
        return $result->fetch_object('Pedido');
    }
    
}
