<?php
namespace models;

class ReceptoresTable extends DatabaseTable{
    public $cedula;
    public $nombre;
    public $apellido;
    public $cargo;

    public function __construct()
    {
        parent::__construct('receptores','cedula','\models\ReceptoresTable',['receptores','cedula']);
    }
}