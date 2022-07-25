<?php

namespace controllers;

use models\UserTable;

class EntryPoint{
    private $route;
    private $method;
    private $routesWeb;

    public function __construct(
        string $route,
        string $method,
        RoutesWeb $routesWeb
    )
    {
        $this->route= $route;
        $this->method= $method;
        $this->routesWeb= $routesWeb;
        $this->verifyRoutes();
    }

    private function verifyRoutes(){
        if($this->route != strtolower($this->route)){
            http_response_code(304);
            header('location:'.$this->route);
        }
    }

    private function loadTemplate($template, $variables=[]){
        extract($variables);
        ob_start();
        include __DIR__ . '/../views/'.$template;
        return ob_get_clean();
    }

    public function run(){
        $rutas = $this->routesWeb->getRoutes();
        $controller = $rutas[$this->route][$this->method]['controller'];
        $action = $rutas[$this->route][$this->method]['action'];
        if(isset($rutas[$this->route]['login']) && 
        !$this->routesWeb->getAutentification()->validationAll()){
            header('location: /');
        }

        if(isset($rutas[$this->route]['permission']) && !$this->routesWeb->hasPermission($rutas[$this->route]['permission']) 
        ||isset($rutas[$this->route]['asignacion']) && !$this->routesWeb->hasAsignacion($rutas[$this->route]['asignacion']) 
        ){
            header('location: /');
        }

        if(isset($rutas[$this->route]['asignacion']) && !$this->routesWeb->hasAsignacion($rutas[$this->route]['asignacion'])){
            header('location: /');
        }
        $result = $controller->$action();
        $title = $result['title'];

        if(isset($result['variables'])){
            $content = $this->loadTemplate($result['template'],$result['variables']);
        }else{
            $content = $this->loadTemplate($result['template']);
            var_dump($title);
        }
        $user = $this->routesWeb->getAutentification()->getUser();

        echo $this->loadTemplate('templates/layout.html.php',[
            'title' => $title,
            'content' => $content,
            'user' => $user
        ]);
    }
}