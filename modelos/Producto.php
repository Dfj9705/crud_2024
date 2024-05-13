<?php
require 'Conexion.php';

class Producto extends Conexion{
    public $prod_id;
    public $prod_nombre;
    public $prod_precio;
    public $prod_situacion;


    public function __construct($args = [])
    {
        $this->prod_id = $args['prod_id'] ?? null;
        $this->prod_nombre = $args['prod_nombre'] ?? '';
        $this->prod_precio = $args['prod_precio'] ?? 0.00;
        $this->prod_situacion = $args['prod_situacion'] ?? 1;
    }

    // METODO PARA INSERTAR
    public function guardar(){
        $sql = "INSERT into productos (prod_nombre, prod_precio) values ('$this->prod_nombre','$this->prod_precio')";
        $resultado = $this->ejecutar($sql);
        return $resultado; 
    }
    
    // METODO PARA CONSULTAR
}