<?php
namespace models;

class EgresoTable extends DatabaseTable{
    public $codigo;
    public $fecha;
    public $receptor;
    public $user;
    public $estado;

    public function __construct()
    {
        parent::__construct('egreso','codigo','\models\EgresoTable',['egreso','codigo']);
        
    }
}