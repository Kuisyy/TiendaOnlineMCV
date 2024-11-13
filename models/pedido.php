<?php
class Pedido {
    private $id_pedido;
    private $id_usr;
    private $nombre;
    private $fecha;
    private $estado;
    private $precioTotal;
    private $direccion;
    private $metodo_pago;
    private $numero_tarjeta;
    private $banco_nombre;
    private $banco_cuenta;

    public function __construct($data) {
        $this->id_pedido = $data['id_pedido'];
        $this->id_usr = $data['id_usr'];
        $this->nombre = $data['nombre'];
        $this->fecha = $data['fecha'];
        $this->estado = $data['estado'];
        $this->precioTotal = $data['precioTotal'];
        $this->direccion = $data['direccion'];
        $this->metodo_pago = $data['metodo_pago'];
        $this->numero_tarjeta = $data['numero_tarjeta'];
        $this->banco_nombre = $data['banco_nombre'];
        $this->banco_cuenta = $data['banco_cuenta'];
    }

    public function getId() { 
        return $this->id_pedido; 
    }
    public function getNombre() { 
        return $this->nombre; 
    }
    public function getFecha() { 
        return $this->fecha; 
    }
    public function getEstado() { 
        return $this->estado; 
    }
    public function getPrecioTotal() { 
        return $this->precioTotal; 
    }
    
    // Nuevas funciones getter para las propiedades agregadas
    public function getDireccion() {
        return $this->direccion;
    }
    
    public function getMetodoPago() {
        return $this->metodo_pago;
    }

    public function getNumeroTarjeta() {
        return $this->numero_tarjeta;
    }

    public function getBancoNombre() {
        return $this->banco_nombre;
    }

    public function getBancoCuenta() {
        return $this->banco_cuenta;
    }
}
?>
