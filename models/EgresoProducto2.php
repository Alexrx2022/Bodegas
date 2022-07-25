<?php
namespace models;

class EgresoProducto2 extends DatabaseTable{
    public $codigo_egreso;
    public $codigo_producto2;
    public $cantidad;

    public function __construct()
    {
        parent::__construct('egreso_producto2','codigo_egreso','\models\EgresoProducto2',
        ['egreso_producto','codigo_egreso']);
    }
}