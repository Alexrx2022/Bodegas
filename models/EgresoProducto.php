<?php
namespace models;

class EgresoProducto extends DatabaseTable{
    public $codigo_egreso;
    public $codigo_producto;
    public $cantidad;

    public function __construct()
    {
        parent::__construct('egreso_producto','codigo_egreso','\models\EgresoProducto',
        ['egreso_producto','codigo_egreso']);
    }
}