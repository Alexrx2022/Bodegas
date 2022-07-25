<?php 
namespace models;

class UserTable extends DatabaseTable{
    public $id;
    public $username;
    public $password;
    public $cargo;
    public $apellido;
    public $permission;
    public $asignacion;
    const ADMIN=16;
    const BODEGERO=6;
    const BODEGA1 = 1;
    const BODEGA2=2;
    public function __construct()
    {
        parent::__construct('user','id','\models\UserTable',['user','id']);
    }

    public function hasPermission($permission){
        return $this->permission & $permission;
    }

    public function hasAsignacion($asignacion){
        return $this->asignacion & $asignacion;
    }
}