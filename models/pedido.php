    <?php
    class Pedido {
        private $id_pedido;
        private $id_usr;
        private $nombre;
        private $fecha;
        private $estado;
        private $precioTotal;

        public function __construct($data) {
            $this->id_pedido = $data['id_pedido'];
            $this->id_usr = $data['id_usr'];
            $this->nombre = $data['nombre'];
            $this->fecha = $data['fecha'];
            $this->estado = $data['estado'];
            $this->precioTotal = $data['precioTotal'];
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
    }
    ?>
