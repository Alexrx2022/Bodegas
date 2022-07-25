<?php 
namespace controllers;

use models\UserTable;

class Login{
    private $userTable;
    private $autentification;

    public function __construct(
        UserTable $userTable,
        Autentification $autentification
    )
    {
        $this->userTable= $userTable;
        $this->autentification= $autentification;
    }
    

    public function loadLogin(){
        $employedVerif = $this->autentification->startSession($_POST['username'],$_POST['password']);
        
        if($employedVerif){
            $user = $this->autentification->getUser();
                if($user->hasPermission(UserTable::ADMIN)){
                    header('location:/inicio/administrado');
                }else if($user->hasAsignacion(UserTable::BODEGA1)){
                    header('location:/list/product');
                }else if($user->hasAsignacion(UserTable::BODEGA2)){
                    header('location:/list/product2');
                }
                
            
        }else{
            return [
                'title'=> 'Página Principal',
                'template' => 'home.html.php',
                'variables' => [
                    'error' => 'Error usuario y / o clave incorrectas'
                ]
            ];
        }
    }

    public function logOut(){
        unset($_SESSION);
        session_destroy();
        header('location: /');
    }
    public function errorSession(){
        return [
            'title' => 'Error de Sesion',
            'template' => 'employed/errorSession.html.php'
        ];
    }
    public function errorPermission(){
        return [
            'title' => 'Error de Sesion',
            'template' => 'employed/errorPermision.html.php'
        ];
    }
}