<?php
require_once 'Conexion.php';

class Cliente extends Conexion{
    public $cli_id;
    public $cli_nombre;
    public $cli_apellido;
    public $cli_nit;
    public $cli_telefono;
    public $cli_situacion;


    public function __construct($args = [])
    {
        $this->cli_id = $args['cli_id'] ?? null;
        $this->cli_nombre = $args['cli_nombre'] ?? '';
        $this->cli_apellido = $args['cli_apellido'] ?? '';
        $this->cli_nit = $args['cli_nit'] ?? '';
        $this->cli_telefono = $args['cli_telefono'] ?? '';
        $this->cli_situacion = $args['cli_situacion'] ?? 1;
    }

    // METODO PARA INSERTAR
    public function guardar(){
        $sql = "INSERT into clientes (cli_nombre, cli_apellido, cli_nit, cli_telefono) values ('$this->cli_nombre','$this->cli_apellido','$this->cli_nit','$this->cli_telefono')";
        $resultado = $this->ejecutar($sql);
        return $resultado; 
    }
    
    // METODO PARA CONSULTAR

    public static function buscarTodos(...$columnas){
        // $cols = '';
        // if(count($columnas) > 0){
        //     $cols = implode(',', $columnas) ;
        // }else{
        //     $cols = '*';
        // }
        $cols = count($columnas) > 0 ? implode(',', $columnas) : '*';
        $sql = "SELECT $cols FROM clientes where cli_situacion = 1 ";
        $resultado = self::servir($sql);
        return $resultado;
    }

    public function buscar(...$columnas){
        $cols = count($columnas) > 0 ? implode(',', $columnas) : '*';
        $sql = "SELECT $cols FROM clientes where cli_situacion = 1 ";

        if($this->cli_nombre != ''){
            $sql .= " AND cli_nombre like '%$this->cli_nombre%' ";
        }
        if($this->cli_apellido != ''){
            $sql .= " AND cli_apellido like '%$this->cli_apellido%' ";
        }
        if($this->cli_nit != ''){
            $sql .= " AND cli_nit like '%$this->cli_nit%' ";
        }
        if($this->cli_telefono != ''){
            $sql .= " AND cli_telefono like '%$this->cli_telefono%' ";
        }
        $resultado = self::servir($sql);
        return $resultado;
    }
}