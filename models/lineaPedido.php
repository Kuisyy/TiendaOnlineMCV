<?php
class LineaPedido {
    private $num_linea;
    private $id_pedido;
    private $id_producto;
    private $cantidad;
    private $precio;  // Precio total de esta línea de pedido

    public function __construct($data) {
        $this->num_linea = $data['num_linea'];
        $this->id_pedido = $data['id_pedido'];
        $this->id_producto = $data['id_producto'];
        $this->cantidad = $data['cantidad'];
        $this->precio = $data['precio'];
    }

    public function getNumLinea() { 
        return $this->num_linea; 
    }
    public function getIdPedido() { 
        return $this->id_pedido; 
    }
    public function getIdProducto() { 
        return $this->id_producto; 
    }
    public function getCantidad() { 
        return $this->cantidad; 
    }
    public function getPrecio() { 
        return $this->precio; 
    }
}
?>
