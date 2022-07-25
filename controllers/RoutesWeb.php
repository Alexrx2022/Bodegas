<?php 
namespace controllers;

use models\EgresoProducto;
use models\EgresoProducto2;
use models\EgresoTable;
use models\Product2Table;
use models\ProductTable;
use models\ProovedoresTable;
use models\ReceptoresTable;
use models\UserTable;

class RoutesWeb{
    private $productTable;
    private $product2Table;
    private $userTable;
    private $autentification;
    private $receptoresTable;
    private $egresoTable;
    private $egreso_productoTable;
    private $egreso_producto2Table;
    private $proovedoresTable;


    public function __construct()
    {
        $this->productTable= new ProductTable;
        $this->userTable= new UserTable;
        $this->autentification= new Autentification($this->userTable,'id','password');
        $this->product2Table= new Product2Table;
        $this->receptoresTable= new ReceptoresTable;
        $this->egresoTable= new EgresoTable;
        $this->egreso_productoTable= new EgresoProducto;
        $this->egreso_producto2Table= new EgresoProducto2;
        $this->proovedoresTable = new ProovedoresTable;
    }


    public function getRoutes(): array
    {
        $homeController = new Home($this->productTable,$this->autentification,
        $this->userTable,$this->product2Table,$this->receptoresTable
        ,$this->egresoTable,$this->egreso_productoTable,$this->egreso_producto2Table,$this->proovedoresTable);
        $loginController = new Login($this->userTable,$this->autentification);
        $adminController = new Admin($this->productTable,$this->autentification,$this->userTable,$this->receptoresTable);

        $path = '';
        return [
            $path => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'home'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'loadLogin'
                ]
                ],
            'list/product' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'listProduct',
                ],
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'addProduct'
                ],
                'login' => true
                ],
            'list/product2' => [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'listProduct2',
                    ],
                    'POST' => [
                        'controller' => $homeController,
                        'action' => 'addProduct2'
                    ],
                    'login' => true
                    ],
            'edit/product' => [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'editProduc'
                    ],
                    'POST' => [
                        'controller' => $homeController,
                        'action' => 'updateProduct'
                    ],
                    'login' => true
                    ],
                'edit/product2' => [
                        'POST' => [
                            'controller' => $homeController,
                            'action' => 'updateProduct2'
                        ],
                        'login' => true
                        ],
            'delete/product' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'deleteProduct'
                ],
                'login' => true
                ],
            'delete/product2' => [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'deleteProduct2'
                    ],
                    'login' => true
                    ],
            'egreso/product'=> [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'egresoView'
                ],
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'saveEgreso'
                ],
                'login' => true
                ],
            'egreso/final' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'presentacionFinal'
                ],
            ],
            'egreso/product2'=> [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'egresoView2'
                    ],
                    'POST' => [
                        'controller' => $homeController,
                        'action' => 'saveEgreso2'
                    ],
                    'login' => true
                    ],
            'inicio/administrado' => [
                'GET' => [
                    'controller' => $adminController,
                    'action' => 'home'
                ],
                'login' => true,
                'permission' => UserTable::ADMIN
            ],
            'get/proovedores' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'getProovedores'
                ],
                'login' => true,
            ],
            'register/admin' =>[
                'POST' => [
                    'controller' => $adminController,
                    'action' => 'addUser'
                ],
                'login' => true,
                'permission' => UserTable::ADMIN
            ],
            'add/proovedor' =>[
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'addProovedor'
                ],
                'login' => true
            ],
            'verificacion' => [
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'verificacion'
                ]
                ],
            'register/receptores/admin' => [
                'POST' => [
                    'controller' => $adminController,
                    'action' => 'registerReceptores'
                ]
            ],
            'agregar/valor' =>[
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'aggValor'
                ]
            ],
            'more/stock' =>[
                'POST' => [
                    'controller' => $homeController,
                    'action' => 'moreStock'
                ]
            ],
            'historial' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'historial'
                ]
            ],
            'historial/bodegas' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'historialBodegas'
                ]
            ],
            'get/products/simple' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'getProductos'
                ]
            ],
            'salir' =>[
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'logOut'
                ]
            ]
        ];
    }

    public function getAutentification(){
        return $this->autentification;
    }

    public function hasPermission($permission){
        $user = $this->autentification->getUser();

        return $user->hasPermission($permission);
    }

    public function hasAsignacion($asignacion){
        $user = $this->autentification->getUser();
        return $user->hasAsignacion($asignacion);
    }
}