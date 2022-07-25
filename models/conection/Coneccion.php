<?php

namespace models\conection;

include __DIR__ .'/../../config.php';
class Coneccion{
    private $host = HOST;
    private $user = USER;
    private $pass = PASS;
    private $dbname = DBNAME;
    private $conn ;

    public function getConection(){
        $this->conn= new \PDO( 'mysql:host'.$this->host.';port=3306;setchar=utf8;dbname='.$this->dbname,$this->user,$this->pass);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        return $this->conn;
    }
}