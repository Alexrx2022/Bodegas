<?php 
namespace models;

class ProovedoresTable extends DatabaseTable{
    public $id;
    public $nombre;
    public $email;
    public $direccion;
    public $telefono;
    public function __construct()
    {
        parent::__construct('proovedores','id','\models\ProovedoresTable',['proovedores','id']);
    }

}