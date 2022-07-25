<?php 
namespace models;

class ProductTable extends DatabaseTable {
    public $id;
    public $proname;
    public $descripcion;
    public $amount;
    public $time;
    public $estado;
    public $medida;

    public function __construct()
    {
        parent::__construct('product','id','\models\ProductTable',['product','id']);
    }
}