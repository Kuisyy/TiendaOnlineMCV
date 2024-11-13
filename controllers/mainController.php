<?php
require_once("models/user.php");
require_once("models/userRepository.php");
require_once("models/pedidoRepository.php");
require_once("models/lineaPedidoRepository.php");
require_once("controllers/productController.php");

// Manejar el cierre de sesión
if (isset($_GET['logout'])) {
    UserRepository::logout();
    header("Location: index.php");
    exit();
}

// Verifica si el usuario está en sesión
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user->getId();
    require_once("views/logoutView.phtml");

    // Cargar productos
    $products = ProductsRepository::getAllProducts();

    // Verificar el rol para mostrar el CRUD de productos si es administrador
    if ($user->getRol() == 1) {
        require_once("views/crudProducts.phtml");
    }

    require_once("views/mainView.phtml");

    // Agregar línea de pedido
    if (isset($_GET['addLP'])) {
        $productId = $_GET['addLP'];
        $product = ProductsRepository::getProductById($productId);

        if (!$product) {
            echo "Producto no encontrado.";
            exit;
        }

        $pedido = PedidoRepository::getActivePedido($userId);
        if (!$pedido) {
            $pedidoId = PedidoRepository::createPedido($userId);
        } else {
            $pedidoId = $pedido->getId();
        }

        // Añadir línea al pedido y luego obtener todas las líneas
        LineaPedidoRepository::añadirLinea($pedidoId, $product->getId(), $product->getPrice());
        $lineas = LineaPedidoRepository::getLineasByPedido($pedidoId);

        // Recargar el pedido actualizado para la vista
        $pedido = PedidoRepository::getActivePedido($pedidoId);
        $precioTotal = PedidoRepository::obtenerPrecioTotalPedido($pedidoId);
        
        // 4. Actualizar el precio total del pedido en la base de datos
        PedidoRepository::actualizarTotalPedido($pedidoId, $precioTotal);
        exit();
    }

    // Visualizar el pedido actual
    if (isset($_GET['verPedido'])) {
        $pedido = PedidoRepository::getActivePedido($userId);
        if ($pedido) {
            $pedidoId = $pedido->getId();
            $lineas = LineaPedidoRepository::getLineasByPedido($pedidoId);
        } else {
            $lineas = [];
        }
        require_once("views/pedidoView.phtml");
        exit();
    }

    // Finalizar pedido
    if (isset($_POST['finalizarPedido'])) {
        // Obtén el ID del usuario desde la sesión
        $user = $_SESSION['user'];
        $userId = $user->getId();
    
        // Obtén el pedido activo del usuario
        $pedido = PedidoRepository::getActivePedido($userId);
    
        // Verificar si el pedido existe y si está en estado 'en proceso'
        if ($pedido && $pedido->getEstado() == 'en proceso') {
            // Obtener la dirección y método de pago desde el formulario
            $direccion = $_POST['direccion'];
            $metodoPago = $_POST['metodo_pago'];
    
            // Obtener datos adicionales según el método de pago
            $numeroTarjeta = ($metodoPago == 'tarjeta') ? $_POST['numero_tarjeta'] : null;
            $bancoNombre = ($metodoPago == 'banco') ? $_POST['banco_nombre'] : null;
            $bancoCuenta = ($metodoPago == 'banco') ? $_POST['banco_cuenta'] : null;
    
            // 3. Actualizar el pedido con la dirección y otros datos
            PedidoRepository::actualizarPedidoConDireccion($pedido->getId(), $direccion, $metodoPago, $numeroTarjeta, $bancoNombre, $bancoCuenta);
    
            // 4. Marcar el pedido como pagado si es necesario
            if ($metodoPago == 'tarjeta') {
                PedidoRepository::marcarPedidoComoPagado($pedido->getId());
            }
            if ( $metodoPago == 'banco') {
                PedidoRepository::marcarPedidoFinalizado($pedido->getId());
            }

           
    
            // Redirigir a la página de confirmación de pedido finalizado
            require_once("views/pedidoFinalizadoView.phtml");
            exit;
        } else {
            // Si el pedido no está en proceso, redirigir a una página de error o mensaje
            echo "El pedido no está en proceso.";
            exit;
        }
    }
    

    // Eliminar línea de pedido
    if (isset($_POST['removeLine'])) {
        $lineaId = $_POST['lineaId'];
        LineaPedidoRepository::eliminarLinea($lineaId);
    }

    // Controlador MainController
if (isset($_GET['productosMasVendidos'])) {
    // Obtener los productos más vendidos
    $productosMasVendidos = ProductsRepository::getProductosMasVendidos();
    require_once("views/productosMasVendidosView.phtml");
}

if (isset($_GET['usuariosMasDinero'])) {
    // Obtener el usuario que más ha gastado
    $usuarioMasGastado = UserRepository::getUsuarioQueMasHaGastado();
    require_once("views/usuarioMasDineroView.phtml");
}


    // Redirigir a una página de confirmación o historial de pedidos
    require_once("views/pedidoFinalizadoView.phtml");

} else {
    // Si no hay usuario en sesión, carga el controlador de login
    require_once("controllers/loginController.php");
    require_once("views/loginView.phtml");
}
?>
