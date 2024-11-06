<?php
require_once("./models/lineaPedidoRepository.php");
require_once("./models/lineaPedido.php");


if (isset($_GET['addLP'])) {
    if (!isset($_SESSION['user'])) {
        echo "Inicie sesión para añadir productos al pedido.";
        exit;
    }

    $productId = $_GET['addLP'];
    $product = ProductsRepository::getProductById($productId);

    if (!$product) {
        echo "Producto no encontrado.";
        exit;
    }

    $userId = $_SESSION['user']->getId();
    
    // Obtener o crear el pedido activo del usuario
    $pedido = PedidoRepository::getActivePedido($userId);
    if ($pedido) {
        $pedidoId = $pedido->getId();
    } else {
        $pedidoId = PedidoRepository::createPedido($userId);
    }

    LineaPedidoRepository::añadirLinea($pedidoId, $product->getId(), $product->getPrice());
    $lineas = LineaPedidoRepository::getLineasByPedido($pedidoId);

    header("Location: ./views/pedidoView.phtml?pedidoId=" . $pedidoId);
    exit;
}


if (isset($_POST['removeLine'])) {
    $lineaId = $_POST['lineaId'];
    LineaPedidoRepository::eliminarLinea($lineaId);

    // Redireccionar de nuevo a la vista del pedido
    header("Location: ./views/pedido.php");
    exit;
}

if (isset($_POST['finalizePedido'])) {
    $pedidoId = $_POST['pedidoId'];
    PedidoRepository::finalizePedido($pedidoId);

    // Redireccionar a una página de confirmación o al historial de pedidos
    header("Location: ./views/pedidoFinalizado.php");
    exit;
}
?>
