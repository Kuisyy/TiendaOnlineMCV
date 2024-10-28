<?php

class Products 
{
	private $id;
	private $id_usr;
    private $price;
    private $name;
    private $description;
    private $stock;
	
	function __construct($datos)
	{
        $this->id = $datos['id_product'];
		$this->id_usr=$datos['id_usr'];
        $this->price = $datos['price'];
        $this->name = $datos['name'];
        $this->description = $datos['description'];
        $this->stock = $datos['stock'];

	}
    public function getId() {
        return $this->id;
    }
    public function getid_usr(){
        return $this->id_usr;
    }
    public function getprice(){
        return $this->price;
    }
    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getStock(){
        return $this->stock;
    }
}

?>