<?php
class LineaPedido {
    private $num_linea;
    private $id_pedido;
    private $id_product;
    private $cantidad;
    private $precio;  // Precio total de esta línea de pedido
    private $precio_unitario; // Agregado para el precio unitario

    public function __construct($data) {
        $this->num_linea = $data['num_linea'];
        $this->id_pedido = $data['id_pedido'];
        $this->id_product = $data['id_product'];
        $this->cantidad = $data['cantidad'];
        $this->precio = $data['precio'];
        
        // Puedes obtener el precio unitario desde un método de ProductRepository si lo deseas
        $this->precio_unitario = $data['precio'] / $this->cantidad; // Asegúrate de que la cantidad no sea cero
    }

    public function getNumLinea() { 
        return $this->num_linea; 
    }
    public function getIdPedido() { 
        return $this->id_pedido; 
    }
    public function getIdProducto() { 
        return $this->id_product; 
    }
    public function getCantidad() { 
        return $this->cantidad; 
    }
    public function getPrecio() { 
        return $this->precio; 
    }
    public function getPrecioUnitario() {
        return $this->precio_unitario; // Devuelve el precio unitario
    }
    public function getProductName() {
        $product = ProductsRepository::getProductById($this->id_product);
        return $product ? $product->getName() : 'Producto no encontrado';
    }
    

}

?>
