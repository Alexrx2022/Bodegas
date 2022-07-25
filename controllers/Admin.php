<?php 
namespace controllers;
use DateTime;
use models\ProductTable;
use models\ReceptoresTable;
use models\UserTable;
class Admin{

    private $productTable;
    private $autentification;
    private $userTable;
    private $receptorTable;

    public function __construct(
        ProductTable $productTable,
        Autentification $autentification,
        UserTable $userTable,
        ReceptoresTable $receptoresTable
    )
    {
        $this->productTable= $productTable;
        $this->autentification= $autentification;
        $this->userTable= $userTable;
        $this->receptorTable= $receptoresTable;
    }

    public function home(){
        $user = $this->autentification->getUser();
        return[
            'title' => 'Inicio de administrador',
            'template' => 'admin/inicio.html.php',
            'variables' => [
                'user' => $user
            ]
        ];
    }
    public function addUser(){
        $dataUser = [
            'username' => $_POST['username'],
            'password' => md5($_POST['password']),
            'cargo' => $_POST['cargo'],
            'apellido' => $_POST['apellido'],
            'asignacion' => $_POST['bodega'],
            'permission' => 6
        ];
        
        $this->userTable->insert($dataUser);
        $user = $this->autentification->getUser();
        return[
            'title' => 'Inicio de administrador',
            'template' => 'admin/inicio.html.php',
            'variables' => [
                'user' => $user,
                'aler' => "<script>alert('Se registro correctamente el usuario')</script>"
            ]
        ];
    }
    public function registerReceptores(){
        $dataReceptor = [
            'cedula' => $_POST['cedula'],
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'cargo' => $_POST['cargo'],
            'bodega' => intval($_POST['bodega'],10)
        ];
        try{
            $this->receptorTable->insert($dataReceptor);
            echo json_encode(['done' => 'Se agrego corectamente al receptor']);
            die;
        }catch(\PDOException $e){
            echo json_encode(['done' => 'Error: '.$e->getMessage()]);
            die;
        }
    }

}