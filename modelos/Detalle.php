<?php

require_once 'Conexion.php';

class Detalle extends Conexion {
    public $det_id;
    public $det_factura;
    public $det_producto;
    public $det_cantidad;
    public $det_situacion;

    public function __construct($args = [])
    {
        $this->det_id = $args['det_id'] ?? null;
        $this->det_factura = $args['det_factura'] ?? null;
        $this->det_producto = $args['det_producto'] ?? null;
        $this->det_cantidad = $args['det_cantidad'] ?? null;
        $this->det_situacion = $args['det_situacion'] ?? 1;
    }

    public function guardar(){
        $sql = "INSERT into detalle_factura (det_factura, det_producto, det_cantidad) values ('$this->det_factura','$this->det_producto', '$this->det_cantidad')";
        $resultado = $this->ejecutar($sql);
        return $resultado; 
    }

    public function buscarPorEncabezado($idEncabezado){
     
        $sql = "SELECT prod_nombre as descripcion, prod_precio as precio_unitario, det_cantidad as cantidad, prod_precio * det_cantidad as subtotal from detalle_factura inner join productos on prod_id = det_producto where det_factura = $idEncabezado  ";
        $resultado =self::servir($sql);
        return $resultado;
    }
    
}