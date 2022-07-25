<?php 

namespace controllers;

use models\UserTable;

class Autentification{
    private $userTable;
    private $ci;
    private $clave;

    public function __construct(
        UserTable $userTable,
        string $ci,
        string $clave
    )
    {
        $this->userTable= $userTable;
        $this->ci=$ci;
        $this->clave= $clave;
        session_start();
    }

    public function startSession(string $ci, string $clave): bool
    {

        $employe = $this->userTable->selectFromColumn('username',$ci);
        if($employe && md5($clave) == $employe[0]->password ){
            session_regenerate_id();
            $_SESSION['user'] = $ci;
            $_SESSION['password'] = $employe[0]->{$this->clave};

            return true;
        }else{
            return false;
        }

    }

    public function validationAll(){

        if(empty($_SESSION['user'])){
            return false;
        }
        
        $result = $this->userTable->selectFromColumn('username', $_SESSION['user'])[0];

        
        if($result->{$this->clave} == $_SESSION['password']){
            return true;
        }else{
            return false;
        }
    }

    public function getUser(){

        if($this->validationAll()){
            return $this->userTable->selectFromColumn('username', $_SESSION['user'])[0];
        }else{
            return false;
        }
        
    }

}