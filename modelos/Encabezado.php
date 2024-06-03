<?php

require_once 'Conexion.php';

class Encabezado extends Conexion {
    public $fact_id;
    public $fact_cliente;
    public $fact_fecha;
    public $fact_correlativo;
    public $fact_situacion;

    public function __construct($args = [])
    {
        $this->fact_id = $args['fact_id'] ?? null;
        $this->fact_cliente = $args['fact_cliente'] ?? null;
        $this->fact_fecha = $args['fact_fecha'] ?? null;
        $this->fact_correlativo = $args['fact_correlativo'] ?? null;
        $this->fact_situacion = $args['fact_situacion'] ?? 1;
    }

    public function guardar(){
        $sql = "INSERT into encabezado_factura(fact_cliente, fact_fecha, fact_correlativo) values ('$this->fact_cliente','$this->fact_fecha', '$this->fact_correlativo')";
        $resultado = $this->ejecutar($sql);
        return $resultado; 
    }


    public function buscar(){
        
     
        $sql = "SELECT * FROM encabezado_factura INNER JOIN clientes ON fact_cliente = cli_id WHERE fact_situacion = 1";

        if($this->fact_fecha != ''){
            $sql .= " AND fact_fecha = '$this->fact_fecha' ";
        }
        if($this->fact_cliente != ''){
            $sql .= " AND fact_cliente = $this->fact_cliente ";
        }

        $sql .= " ORDER BY fact_fecha desc ";

        $resultado = self::servir($sql);
        return $resultado;
    }


    public function buscarPorId($id){
     
        $sql = "SELECT * FROM encabezado_factura INNER JOIN clientes ON fact_cliente = cli_id where fact_situacion = 1 and fact_id = $id ";
        $resultado = array_shift( self::servir($sql));
        // $resultado = self::servir($sql)[0];
        return $resultado;
    }

}