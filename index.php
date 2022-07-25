<?php
include __DIR__ . '/vendor/autoload.php';

use controllers\EntryPoint;
use controllers\RoutesWeb;

/**
 * Aqui se toma la ruta en la variable $route 
 */

try {
    $route = ltrim( strtok($_SERVER['REQUEST_URI'],'?'),'/');
    $entryPoint = new EntryPoint($route,$_SERVER['REQUEST_METHOD'], new RoutesWeb);
    $entryPoint->run();
    
} catch (\PDOException $e) {
    $title = 'ERROR BASE DATOS';
    $content = 'Error: ' .$e->getMessage() . ' in: ' . $e->getFile() . ' : ' . $e->getLine();

    include __DIR__ . '/views/templates/layout.html.php';
}