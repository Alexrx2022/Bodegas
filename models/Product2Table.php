<?php 
namespace models;

class Product2Table extends DatabaseTable {
    public $id;
    public $proname;
    public $descripcion;
    public $amount;
    public $time;
    public $estado;
    public $medida;
    public function __construct()
    {
        parent::__construct('product2','id','\models\Product2Table',['product2','id']);
    }
}