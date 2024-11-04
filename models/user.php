    <?php

    class User 
    {
        private $id;
        private $username;
        private $rol;
        
        function __construct($datos)
        {
            $this->id = $datos['id_usr'];
            $this->username=$datos['username'];
            $this->rol = $datos['rol'];
        }
        public function getId() {
            return $this->id;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getRol(){
            return $this->rol;
        }
    }

    ?>