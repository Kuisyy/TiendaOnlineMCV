<?php
require_once("models/pedido.php");
require_once("db.php");

class PedidoRepository {

    // Crear un nuevo pedido y retorna su ID
    public static function createPedido($id_usr) {
        $conexion = Conectar::conexion();
        $nombre = "Pedido de " . date('Y-m-d H:i:s'); // Nombre único para el pedido
        $sql = "INSERT INTO pedido (id_usr, nombre, fecha, estado, precioTotal) 
                VALUES ($id_usr, '$nombre', NOW(), 'en proceso', 0)";
        $conexion->query($sql);
        return $conexion->insert_id; // Retorna el ID del pedido creado
    }

    // Obtener el pedido activo del usuario (estado 'En Proceso')
    public static function getActivePedido($userId) {
        $db = Conectar::conexion();
        $query = "SELECT * FROM pedido WHERE id_usr = '$userId' AND estado = 'en proceso'";
        $result = $db->query($query);
    
        if ($result && $row = $result->fetch_assoc()) {
            return new Pedido($row);
        }
        return null;
    }

    // Obtener un pedido por su ID
    public static function getPedidoById($id_pedido) {
        $db = Conectar::conexion();
        $query = "SELECT * FROM pedido WHERE id_pedido = '$id_pedido'";
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Pedido($row);
        }
        return null;
    }

    // Actualizar un pedido con la dirección y detalles del pago
    public static function actualizarPedidoConDireccion($id_pedido, $direccion, $metodoPago, $numeroTarjeta = null, $bancoNombre = null, $bancoCuenta = null) {
        $db = Conectar::conexion();
        $query = "UPDATE pedido SET 
                    direccion = '$direccion', 
                    metodo_pago = '$metodoPago', 
                    numero_tarjeta = '$numeroTarjeta', 
                    banco_nombre = '$bancoNombre', 
                    banco_cuenta = '$bancoCuenta' 
                  WHERE id_pedido = '$id_pedido'";
        $db->query($query);
    }

    // Marcar un pedido como pagado (si el pago fue con tarjeta o con banco)
    public static function marcarPedidoComoPagado($id_pedido) {
        $db = Conectar::conexion();
        $query = "UPDATE pedido SET estado = 'pagado' WHERE id_pedido = '$id_pedido'";
        $db->query($query);
    }

    // Añadir una línea de producto a un pedido
    public static function addLineToPedido($id_pedido, $id_product, $cantidad, $precio_unitario) {
        $conexion = Conectar::conexion();
        $precio_total = $cantidad * $precio_unitario;
        $sql = "INSERT INTO lineapedido (id_pedido, id_product, cantidad, precio) 
                VALUES ($id_pedido, $id_product, $cantidad, $precio_total)";
        $conexion->query($sql);
    }

    // Finalizar un pedido (cambiar estado a 'Finalizado')
    public static function marcarPedidoFinalizado($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "UPDATE pedido SET estado = 'finalizado' WHERE id_pedido = $id_pedido";
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

    // Actualizar el total del pedido basado en las líneas de pedido
    public static function actualizarTotalPedido($id_pedido) {
        $conexion = Conectar::conexion();
        $sql = "UPDATE pedido SET precioTotal = (
                    SELECT SUM(precio) FROM lineapedido WHERE id_pedido = $id_pedido
                ) WHERE id_pedido = $id_pedido";
        $conexion->query($sql);
    }

    // Obtener el precio total de un pedido
    public static function obtenerPrecioTotalPedido($id_pedido) {
        $db = Conectar::conexion();
        $query = "SELECT SUM(precio) AS total FROM lineapedido WHERE id_pedido = '$id_pedido'";
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0; 
    }
}
