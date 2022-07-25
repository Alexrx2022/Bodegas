<?php

namespace controllers;

use DateTime;
use models\EgresoProducto;
use models\EgresoProducto2;
use models\EgresoTable;
use models\Product2Table;
use models\ProductTable;
use models\ProovedoresTable;
use models\ReceptoresTable;
use models\UserTable;

class Home{
    private $productTable;
    private $autentification;
    private $userTable;
    private $product2Table;
    private $receptoresTable;
    private $egresoTable;
    private $egreso_productoTable;
    private $egreso_producto2Table;
    private $proovedoresTable;
    private $codigoInitial = '2022-000';
    public function __construct(
        ProductTable $productTable,
        Autentification $autentification,
        UserTable $userTable,
        Product2Table $product2Table,
        ReceptoresTable $receptoresTable,
        EgresoTable $egresoTable,
        EgresoProducto $egreso_productoTable,
        EgresoProducto2 $egreso_producto2Table,
        ProovedoresTable $proovedoresTable

    )
    {
        $this->productTable= $productTable;
        $this->autentification= $autentification;
        $this->userTable= $userTable;
        $this->product2Table= $product2Table;
        $this->receptoresTable= $receptoresTable;
        $this->egresoTable = $egresoTable;
        $this->egreso_productoTable= $egreso_productoTable;
        $this->egreso_producto2Table= $egreso_producto2Table;
        $this->proovedoresTable= $proovedoresTable;
    }

    public function home(){
        $dataUser = [
            'username' => 'Alexis',
            'apellido' => 'Cueva',
            'cargo' => 'Administrador',
            'permission' => 16,
            'password' => md5('1234')
        ];
        //$this->userTable->insert($dataUser);
        return [
            'title'=> 'Página Principal',
            'template' => 'home.html.php'
        ];
    }

    public function listProduct(){
        $productos = $this->productTable->select();
        $user = $this->autentification->getUser();
        return [
            'title' => 'Lista Productos',
            'template' => 'lista_productos.html.php',
            'variables' => [
                'productos' => $productos,
                'user' => $user
            ]
        ];
    }
    public function addProduct(){
        $productAdd = [
            'proname' => $_POST['name'],
            'descripcion' => $_POST['descrip'],
            'amount' => $_POST['amount'],
            'medida' => $_POST['valor'],
            'id_proovedor' => $_POST['proovedor']
        ];
        
        $this->productTable->insert($productAdd);
        $productos = $this->productTable->select();
        $user = $this->autentification->getUser();
        return [
            'title' => 'Lista Productos',
            'template' => 'lista_productos.html.php',
            'variables' => [
                'productos' => $productos,
                'alert' => '<script>alert("Se ingreso correctamente el producto")</script>',
                'user' => $user
            ]
        ];
    }

    public function editProduc(){
        if(isset($_GET['id']) && intval($_GET['bodega']) == 1){
            $product = $this->productTable->selectFromColumn('id',$_GET['id']);
            if($product){
                echo json_encode($product[0],JSON_UNESCAPED_UNICODE);
                die;
            }else{
                echo json_encode(['error' => 'No se encontro un producto']);
                die;
            }
        }else if(isset($_GET['id']) && intval($_GET['bodega']) == 2){
            $product = $this->product2Table->selectFromColumn('id',$_GET['id']);
            if($product){
                echo json_encode($product[0],JSON_UNESCAPED_UNICODE);
                die;
            }else{
                echo json_encode(['error' => 'No se encontro un producto']);
                die;
            }
        }else{
            echo json_encode(['error' => 'No se encontro un producto']);
            die;
        }
    }
    public function updateProduct(){
        if(isset($_POST['estado']) && isset($_GET['bodega']) ){
            if($_GET['bodega']==1){
                $dataUpdate = [
                    'estado' => $_POST['estado'],
                    'id' => $_POST['id']
                ];
                try {
                    $this->productTable->update($dataUpdate);
                    echo  json_encode(['done' => 'Se guardo estado']);
                    die;
                } catch (\PDOException $th) {
                    echo  json_encode(['done' => 'No se pudo guardar el estado']);
                    die;
                }
            }else{
                $dataUpdate = [
                    'estado' => $_POST['estado'],
                    'id' => $_POST['id']
                ];
                try {
                    $this->product2Table->update($dataUpdate);
                    echo  json_encode(['done' => 'Se guardo estado']);
                    die;
                } catch (\PDOException $th) {
                    echo  json_encode(['done' => 'No se pudo guardar el estado']);
                    die;
                }
            }
               
        }else{
        date_default_timezone_set('America/Guayaquil');
        $time = new DateTime();
        $fecha = $time->format('Y-m-d H:i:s');
        $dataUpdate = [
            'proname' => $_POST['name'],
            'descripcion' => $_POST['descrip'],
            'amount' => $_POST['value'],
            'id' => $_POST['id'],
            'time' => $fecha
        ];
        $this->productTable->update($dataUpdate);
        //$productos = $this->productTable->select();
        echo '<script>alert("Se Actualizo el producto")</script>';
        // return [
        //     'title' => 'Lista Productos',
        //     'template' => 'lista_productos.html.php',
        //     'variables' => [
        //         'productos' => $productos,
        //         'alert' => '<script>alert("Se Actualizo el producto")</script>'
        //     ]
        // ];
        header('location: /list/product');
        exit();
        }
    }
    
    public function deleteProduct(){
        if(isset($_GET['id'])){
            $this->productTable->delete($_GET['id']);
            header('location:/list/product');
        }else{
            header('location:/list/product');
        }
    }

    public function egresoView(){
        $data  = file_get_contents('./models/json/cargos.json');
        $cargos = json_decode($data,true)["cargos"];
        $productos = $this->productTable->select();
        $receptores = $this->receptoresTable->select();
        $user = $this->autentification->getUser();
            return[
                'title' => 'Salida de Producto',
                'template' => 'salida.html.php',
                'variables' => [
                    'productos' => $productos,
                    'cargos' => $cargos,
                    'receptores' => $receptores,
                    'user' => $user,
                    'bodega' => 1
                ]
            ];
        
       
    }

    public function saveEgreso(){
        $user = $this->autentification->getUser();
        $idReceptor  = $_POST['idreceptor'];
        $datos = json_decode($_POST['productos'],true);
        if(isset($_POST['resta'])){
            
            foreach($datos as $dato){
                 $producto = $this->productTable->selectFromColumn('id',$dato['id'])[0];
                 $cant = intval($producto->amount,10) - intval($dato['cant'])   ;
                 $dataProduct = [
                     'amount' => $cant,
                     'id' => $dato['id'],
                 ];

                 $this->productTable->update($dataProduct);
            }
            $updateEgreso = [
                'estado' => 'Completado',
                'codigo' => $_POST['codigo']
            ];
            $this->egresoTable->update($updateEgreso);
            die;

            
        }else{
            date_default_timezone_set('America/Guayaquil');
            $productos = $this->egresoTable->select();
            $codigo = '';
            $date = new \DateTime();
            if(count($productos) != 0 ){
                $codigo = $productos[count($productos)-1]->codigo;
            }else{
                $codigo = $this->codigoInitial;
            }

            $newCod = Utiles::codigoActa($codigo);

            $dataEgreso = [
                'codigo' => $newCod,
                'fecha' => $date->format('Y-m-d H:i:s'),
                'receptor' => $_POST['idreceptor'],
                'user' => $user->id,
                'estado' => 'Cancelado'
            ];
            
            $egreso = $this->egresoTable->insertUltimate($dataEgreso);
            $productosIda = [];
            foreach($datos as $dato){
                $productoIda = $this->productTable->selectFromColumn('id',$dato['id'])[0];
                $productosIda[] = $productoIda;
                $data_egreso_producto = [
                    'codigo_egreso' => $egreso->codigo,
                    'codigo_producto' => $dato['id'],
                    'cantidad' => $dato['cant'],
                    
                ];
                try{
                    $this->egreso_productoTable->insert($data_egreso_producto);
                }catch(\PDOException $e){
                    echo json_encode(['Error' => $e->getMessage(). ' in ' . $e->getFile(). ' : '. $e->getLine()]);
                }
                
               
            }          
            echo json_encode([
                'emisor' => $user->username,
                'codigo' => $egreso->codigo,
                'fecha' => $date->format('Y-m-d H:i:s'),
                'productos' => $productosIda               
            ]);
        }
            
        die;
    //     $cantidades = [];
    //     for($i=0; $i < count($_POST['cantidad']); $i++){
    //         if($_POST['cantidad'][$i] != ''){
    //             // echo "<br> si"; 
    //            array_push($cantidades,$_POST['cantidad'][$i]);
    //         }
    //     }
    //     date_default_timezone_set('America/Guayaquil');
    //     $user = $this->autentification->getUser();
    //    $data = file_get_contents('./models/json/historial.json');
    //    $historial = json_decode($data,true);
    //    $productos = [];
    //     $date = new \DateTime();
    //     for($i=0; $i < count($_POST['productos']) ; $i++){
    //         $product = $this->productTable->selectFromColumn('id',$_POST['productos'][$i])[0];
    //         array_push($productos,$product);
    //         $dataHistorial = [
    //             'fecha' => $date->format('Y-m-d H:i:s'),
    //             'bodegero'=> $user->username . ' ' . $user->apellido,
    //             'nombre' => $product->proname,
    //             'solicitante' => $_POST['nombre'] . ' ' . $_POST['apellido'],
    //             'cantidad' => $cantidades[$i]
    //         ];
    //         $cantidad =  $product->amount - intval($cantidades[$i]);
    //         $params = [
    //             'amount' => $cantidad,
    //             'id' => $_POST['productos'][$i]
    //         ];
    //         $this->productTable->update($params);
    //         $historial['historial'][] = $dataHistorial;
    //         file_put_contents('./models/json/historial.json',json_encode($historial,JSON_UNESCAPED_UNICODE));
    //     }       
    //     return[
    //         'title' => 'Generar Acta',
    //         'template' => 'acta.html.php',
    //         'variables' => [
    //             'productos' => $productos,
    //             'user' => $user,
    //             'date' => $date,
    //             'cantidades' => $cantidades
    //         ]
    //         ];
    }
    public function logOut(){
        unset($_SESSION);
        session_destroy();
        header('location: /');
    }

//     Aqui empieza todo para la segunda bodega



    public function listProduct2(){
        $productos = $this->product2Table->select();
        $user = $this->autentification->getUser();
        return [
            'title' => 'Lista Productos',
            'template' => 'lista_productos2.html.php',
            'variables' => [
                'productos' => $productos,
                'user' => $user
            ]
        ];
    }
    public function addProduct2(){
        $productAdd = [
            'proname' => $_POST['name'],
            'descripcion' => $_POST['descrip'],
            'amount' => $_POST['amount'],
            'medida' => $_POST['valor'],
            'id_proovedor' => $_POST['proovedor']
        ];
        
        $this->product2Table->insert($productAdd);
        $productos = $this->product2Table->select();
        $user = $this->autentification->getUser();
        return [
            'title' => 'Lista Productos',
            'template' => 'lista_productos2.html.php',
            'variables' => [
                'productos' => $productos,
                'alert' => '<script>alert("Se ingreso correctamente el producto")</script>',
                'user' => $user
            ]
        ];
    }
    public function updateProduct2(){
        if(isset($_POST['estado'])){
            $dataUpdate = [
                'estado' => $_POST['estado'],
                'id' => $_POST['id']
            ];
            try {
                $this->product2Table->update($dataUpdate);
                echo  json_encode(['done' => 'Se guardo el estado']);
                die;
            } catch (\PDOException $th) {
                echo  json_encode(['done' => 'No se pudo guardar el estado']);
                die;
            }   
        }else{
        date_default_timezone_set('America/Guayaquil');
        $time = new DateTime();
        $fecha = $time->format('Y-m-d H:i:s');
        $dataUpdate = [
            'proname' => $_POST['name'],
            'descripcion' => $_POST['descrip'],
            'amount' => $_POST['value'],
            'id' => $_POST['id'],
            'time' => $fecha
        ];
        $this->product2Table->update($dataUpdate);
        //$productos = $this->productTable->select();
        echo '<script>alert("Se Actualizo el producto")</script>';
        // return [
        //     'title' => 'Lista Productos',
        //     'template' => 'lista_productos.html.php',
        //     'variables' => [
        //         'productos' => $productos,
        //         'alert' => '<script>alert("Se Actualizo el producto")</script>'
        //     ]
        // ];
        header('location: /list/product2');
        exit();
        }
    }
    public function deleteProduct2(){
        if(isset($_GET['id'])){
            $this->product2Table->delete($_GET['id']);
            header('location:/list/product2');
        }else{
            header('location:/list/product2');
        }
    }

    public function egresoView2(){
        $data  = file_get_contents('./models/json/cargos.json');
        $cargos = json_decode($data,true)["cargos"];
        $productos = $this->product2Table->select();
        $receptores = $this->receptoresTable->select();
        $user = $this->autentification->getUser();
            return[
                'title' => 'Salida de Producto',
                'template' => 'salida.html.php',
                'variables' => [
                    'productos' => $productos,
                    'cargos' => $cargos,
                    'receptores' => $receptores,
                    'user' => $user,
                    'bodega' => 2
                ]
            ];
        
       
    }
    public function saveEgreso2(){
        $user = $this->autentification->getUser();
        $datos = json_decode($_POST['productos'],true);
        if(isset($_POST['resta']) && isset($_POST['codigo'])){
            
            foreach($datos as $dato){
                 $producto = $this->product2Table->selectFromColumn('id',$dato['id'])[0];
                 $cant = intval($producto->amount,10) - intval($dato['cant'])   ;
                 $dataProduct = [
                     'amount' => $cant,
                     'id' => $dato['id']
                 ];

                 $this->product2Table->update($dataProduct);
            }
            $updateEgreso = [
                'estado' => 'Completado',
                'codigo' => $_POST['codigo']
            ];
            $this->egresoTable->update($updateEgreso);
           
            die;

            
        }else{
            date_default_timezone_set('America/Guayaquil');
            $productos = $this->egresoTable->select();
            $codigo = '';
            $date = new \DateTime();
            if(count($productos) != 0 ){
                $codigo = $productos[count($productos)-1]->codigo;
            }else{
                $codigo = $this->codigoInitial;
            }

            $newCod = Utiles::codigoActa($codigo);

            $dataEgreso = [
                'codigo' => $newCod,
                'fecha' => $date->format('Y-m-d H:i:s'),
                'receptor' => $_POST['idreceptor'],
                'user' => $user->id,
                'estado' => 'Cancelado'
            ];
            
            $egreso = $this->egresoTable->insertUltimate($dataEgreso);
            $productosIda = [];
            foreach($datos as $dato){
                $productoIda = $this->product2Table->selectFromColumn('id',$dato['id'])[0];
                $productosIda[] = $productoIda;
                $data_egreso_producto2 = [
                    'codigo_egreso' => $egreso->codigo,
                    'codigo_producto2' => $dato['id'],
                    'cantidad' => $dato['cant'],
                    
                ];
                try{
                    $this->egreso_producto2Table->insert($data_egreso_producto2);
                }catch(\PDOException $e){
                    echo json_encode(['Error' => $e]);
                }
               
            }          
            echo json_encode([
                'emisor' => $user->username,
                'codigo' => $egreso->codigo,
                'fecha' => $date->format('Y-m-d H:i:s'),
                'productos' => $productosIda               
            ]);
        }
            
        die;

    //     $cantidades = [];
    //     for($i=0; $i < count($_POST['cantidad']); $i++){
    //         if($_POST['cantidad'][$i] != ''){
    //             // echo "<br> si"; 
    //            array_push($cantidades,$_POST['cantidad'][$i]);
    //         }
    //     }
        
    //     $user = $this->autentification->getUser();
    //    $data = file_get_contents('./models/json/historial.json');
    //    $historial = json_decode($data,true);
    //    $productos = [];
    //     $date = new \DateTime();
    //     for($i=0; $i < count($_POST['productos']) ; $i++){
    //         $product = $this->product2Table->selectFromColumn('id',$_POST['productos'][$i])[0];
    //         array_push($productos,$product);
    //         $dataHistorial = [
    //             'fecha' => $date->format('Y-m-d H:i:s'),
    //             'bodegero'=> $user->username . ' ' . $user->apellido,
    //             'nombre' => $product->proname,
    //             'solicitante' => $_POST['nombre'] . ' ' . $_POST['apellido'],
    //             'cantidad' => $cantidades[$i]
    //         ];
    //         $cantidad =  $product->amount - intval($cantidades[$i]);
    //         $params = [
    //             'amount' => $cantidad,
    //             'id' => $_POST['productos'][$i]
    //         ];
    //         $this->product2Table->update($params);
    //         $historial['historial'][] = $dataHistorial;
    //         file_put_contents('./models/json/historial.json',json_encode($historial,JSON_UNESCAPED_UNICODE));
    //     }       
    //     return[
    //         'title' => 'Generar Acta',
    //         'template' => 'acta.html.php',
    //         'variables' => [
    //             'productos' => $productos,
    //             'user' => $user,
    //             'date' => $date,
    //             'cantidades' => $cantidades
    //         ]
    //         ];
    }

    public function verificacion(){
        $user = $this->autentification->getUser();
        if( md5($_POST['password']) == $user->password){
            
            echo json_encode(['done' => true]);
            die;
        }else{
            echo json_encode(['done' => false]);
            die;
        }
    }

    

    public function presentacionFinal(){
        if(isset($_GET['codigo'])&& trim($_GET['bodega']) == 1){
            $user = $this->autentification->getUser();
            $egresos = $this->egreso_productoTable->selectFromColumn('codigo_egreso',$_GET['codigo']);
            $egresosTable = $this->egresoTable->selectFromColumn('codigo',$egresos[0]->codigo_egreso)[0];
            $receptor = $this->receptoresTable->selectFromColumn('cedula',$egresosTable->receptor)[0];
            $productos = [];
            $cantidades = [];
            $date = new \DateTime();
            foreach($egresos as $egreso){
                $productos[] = $this->productTable->selectFromColumn('id',$egreso->codigo_producto)[0];
                $cantidades[] = $egreso->cantidad;
            }
            return[
                'title' => 'Generar Acta',
                'template' => 'acta.html.php',
                'variables' => [
                    'productos' => $productos,
                    'user' => $user,
                    'date' => $date,
                    'receptor' => $receptor,
                    'cantidades' => $cantidades,
                    'codigo' => $egresos[0]->codigo_egreso
                ]
                ];

        }else if(isset($_GET['codigo'])&& trim($_GET['bodega'] == 2)){
            $user = $this->autentification->getUser();
            $egresos = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$_GET['codigo']);
            $egresosTable = $this->egresoTable->selectFromColumn('codigo',$egresos[0]->codigo_egreso)[0];
            $productos = [];
            $cantidades = [];
            $receptor = $this->receptoresTable->selectFromColumn('cedula',$egresosTable->receptor)[0];
            $date = new \DateTime();
            foreach($egresos as $egreso){
                $productos[] = $this->product2Table->selectFromColumn('id',$egreso->codigo_producto2)[0];
                $cantidades[] = $egreso->cantidad;
            }
            
            
            return[
                        'title' => 'Generar Acta',
                        'template' => 'acta.html.php',
                        'variables' => [
                            'productos' => $productos,
                            'user' => $user,
                            'date' => $date,
                            'receptor' => $receptor,
                            'cantidades' => $cantidades,
                            'codigo' => $egresos[0]->codigo_egreso
                        ]
                        ];
        }else{
            header('location: /');
        }
    }

    public function aggValor(){
        $json = file_get_contents('./models/json/valor.json');
        $array = json_decode($json,true);
        $array['valor'][] = $_POST['valor'];

        file_put_contents('./models/json/valor.json',json_encode($array));
        header('location: /');
        exit();
    }

    public function historial(){
        $datos = $this->egresoTable->select();
        $datosF = [];
        foreach($datos as $dato){
           
            $bodeguero = $this->userTable->selectFromColumn('id',$dato->user)[0];
            $solicitante = $this->receptoresTable->selectFromColumn('cedula',$dato->receptor)[0];
            $productos = [];
            try{
                $egreso_producto = $this->egreso_productoTable->selectFromColumn('codigo_egreso',$dato->codigo);
                // if( count($egreso_producto) == 0){
                   
                // }
                if($egreso_producto){
                    foreach($egreso_producto as $producto){
                        $pr = $this->productTable->selectFromColumn('id',$producto->codigo_producto)[0];
                    	$productos[] = [
                            'nombre' => $pr->proname,
                            'cantidad' => $producto->cantidad
                    ];
                }
                }else{
                    $egreso_producto = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$dato->codigo);
                    
                    foreach($egreso_producto as $producto){
                    $pr = $this->product2Table->selectFromColumn('id',$producto->codigo_producto2)[0];
                    $productos[] = [
                        'nombre' => $pr->proname,
                        'cantidad' => $producto->cantidad
                ];
            }
                }
                

            }catch(\PDOException $e){
            //     $egreso_producto = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$dato->codigo);
            //     foreach($egreso_producto as $producto){
            //         $pr = $this->product2Table->selectFromColumn('id',$producto->codigo_producto2)[0];
            //         $productos[] = [
            //             'nombre' => $pr->proname,
            //             'cantidad' => $producto->cantidad
            //     ];
            // }
            }

            
            $datosF[] = [
            'fecha' => $dato->fecha,
            'estado' => $dato->estado,
            'bodeguero' => $bodeguero->username . ' ' . $bodeguero->apellido,
            'solicitante' => $solicitante->nombre . ' ' . $solicitante->apellido,
            'productos' => $productos,
            'bodega' => $bodeguero->asignacion
        ];
        
        }

        echo json_encode(['historial' => $datosF],JSON_UNESCAPED_UNICODE);

        die;
    }

    public function addProovedor(){
        $data = [
            'nombre' => $_POST['name'],
            'email' => $_POST['correo'],
            'telefono' => $_POST['telefono'],
            'direccion' => $_POST['direccion']
        ];
        try{
            $this->proovedoresTable->insert($data);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
        $productos = $this->productTable->select();
        $user = $this->autentification->getUser();
        
        if(trim($_POST['option']) == 1){            
            return [
                'title' => 'Lista Productos',
                'template' => 'lista_productos.html.php',
                'variables' => [
                    'productos' => $productos,
                    'alert' => '<script>alert("Se ingreso correctamente el proovedor")
                    document.location.href= "/";
                    </script>',
                    'user' => $user
                ]
            ];
        }else{
            $productos = $this->product2Table->select();
            return [
                'title' => 'Lista Productos',
                'template' => 'lista_productos2.html.php',
                'variables' => [
                    'productos' => $productos,
                    'alert' => '<script>alert("Se ingreso correctamente el proovedor")
                        document.location.href= "/";
                    </script>',
                    'user' => $user
                ]
            ];
        }
        
    }

    public function getProovedores(){
        $proovedores = $this->proovedoresTable->select(null,null,true,'nombre');
        $res = [
            'proovedores' => $proovedores
        ];

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die;
    }

    public function getProductos(){
        if(isset($_GET['bodega'])){
            if(trim($_GET['bodega']) == 1){
                $productosF = [];
                $productos = $this->productTable->select();
                foreach($productos as $producto){
                    $proovedor = $this->proovedoresTable->selectFromColumn('id',$producto->id_proovedor)[0];
                    $productosF[] =[
                        'nombre' => $producto->proname,
                        'proovedor' => $proovedor->nombre,
                        'id' => $producto->id,
                        'bodega' => 1
                    ];
                }
                echo json_encode(['productos' => $productosF]);
                die;
            }else{
                $productosF = [];
                $productos = $this->product2Table->select();
                foreach($productos as $producto){
                    $proovedor = $this->proovedoresTable->selectFromColumn('id',$producto->id_proovedor)[0];
                    $productosF[] =[
                        'nombre' => $producto->proname,
                        'proovedor' => $proovedor->nombre,
                        'id' => $producto->id,
                        'bodega' => 2
                    ];
                }
                echo json_encode(['productos' => $productosF]);
                die;
            }
            
            
        }

        die;
    }
    
    public function moreStock(){
        if($_POST['bodega'] == 1){
            $producto = $this->productTable->selectFromColumn('id',$_POST['producto'])[0];
            $cant = $producto->amount + intval($_POST['cantidad'],10);
            $productos = $this->productTable->select();
            $user = $this->autentification->getUser();
            $data = [
                'amount' => $cant,
                'id' => $_POST['producto']
            ];

            $this->productTable->update($data);
            return [
                'title' => 'Lista Productos',
                'template' => 'lista_productos.html.php',
                'variables' => [
                    'productos' => $productos,
                    'alert' => '<script>alert("Se aumento correcta el producto")
                    document.location.href= "/";
                    </script>',
                    'user' => $user
                ]
            ];
            
        }else{
            $producto = $this->product2Table->selectFromColumn('id',$_POST['producto'])[0];
            $cant = $producto->amount + intval($_POST['cantidad'],10);
            $productos = $this->productTable->select();
            $user = $this->autentification->getUser();
            $data = [
                'amount' => $cant,
                'id' => $_POST['producto']
            ];

            $this->product2Table->update($data);
            return [
                'title' => 'Lista Productos',
                'template' => 'lista_productos2.html.php',
                'variables' => [
                    'productos' => $productos,
                    'alert' => '<script>alert("Se aumento correcta el producto")
                    document.location.href= "/";
                    </script>',
                    'user' => $user
                ]
            ];
        }

       
    }
    public function historialBodegas(){
        if(isset($_GET['bodega'])){
            if($_GET['bodega'] == 1){
                $user = $this->autentification->getUser();
                $datos = $this->egresoTable->selectFromColumn('user',$user->id);
                $datosF = [];
                foreach($datos as $dato){
                   
                    $bodeguero = $this->userTable->selectFromColumn('id',$dato->user)[0];
                    $solicitante = $this->receptoresTable->selectFromColumn('cedula',$dato->receptor)[0];
                    $productos = [];
                    try{
                        $egreso_producto = $this->egreso_productoTable->selectFromColumn('codigo_egreso',$dato->codigo);
                            foreach($egreso_producto as $producto){
                                $pr = $this->productTable->selectFromColumn('id',$producto->codigo_producto)[0];
                                $productos[] = [
                                    'nombre' => $pr->proname,
                                    'cantidad' => $producto->cantidad
                            ];
                        }
                        
        
                    }catch(\PDOException $e){
                    //     $egreso_producto = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$dato->codigo);
                    //     foreach($egreso_producto as $producto){
                    //         $pr = $this->product2Table->selectFromColumn('id',$producto->codigo_producto2)[0];
                    //         $productos[] = [
                    //             'nombre' => $pr->proname,
                    //             'cantidad' => $producto->cantidad
                    //     ];
                    // }
                    }
        
                    
                    $datosF[] = [
                    'fecha' => $dato->fecha,
                    'estado' => $dato->estado,
                    'bodeguero' => $bodeguero->username . ' ' . $bodeguero->apellido,
                    'solicitante' => $solicitante->nombre . ' ' . $solicitante->apellido,
                    'productos' => $productos
                ];
                }
        
                echo json_encode(['historial' => $datosF],JSON_UNESCAPED_UNICODE);
                die;
        }else{
            
                $user = $this->autentification->getUser();
                $datos = $this->egresoTable->selectFromColumn('user',$user->id);
                $datosF = [];
                foreach($datos as $dato){
                   
                    $bodeguero = $this->userTable->selectFromColumn('id',$dato->user)[0];
                   
                    $solicitante = $this->receptoresTable->selectFromColumn('cedula',$dato->receptor)[0];
            
                    $productos = [];
                    try{
                        $egreso_producto = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$dato->codigo);
                            foreach($egreso_producto as $producto){
                                $pr = $this->product2Table->selectFromColumn('id',$producto->codigo_producto2)[0];
                                
                                $productos[] = [
                                    'nombre' => $pr->proname,
                                    'cantidad' => $producto->cantidad
                            ];
                        }
                        
        
                    }catch(\PDOException $e){
                    //     $egreso_producto = $this->egreso_producto2Table->selectFromColumn('codigo_egreso',$dato->codigo);
                    //     foreach($egreso_producto as $producto){
                    //         $pr = $this->product2Table->selectFromColumn('id',$producto->codigo_producto2)[0];
                    //         $productos[] = [
                    //             'nombre' => $pr->proname,
                    //             'cantidad' => $producto->cantidad
                    //     ];
                    // }
                    }
        
                    
                    $datosF[] = [
                    'fecha' => $dato->fecha,
                    'estado' => $dato->estado,
                    'bodeguero' => $bodeguero->username . ' ' . $bodeguero->apellido,
                    'solicitante' => $solicitante->nombre . ' ' . $solicitante->apellido,
                    'productos' => $productos
                ];
                }
        
                echo json_encode(['historial' => $datosF],JSON_UNESCAPED_UNICODE);
                die;
            
        }
      }
    }
}