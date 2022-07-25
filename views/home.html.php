<?php

use controllers\RoutesWeb;
use models\UserTable;

  if(isset($_SESSION['user'])){
    $rutas = new RoutesWeb();
    $user = $rutas->getAutentification()->getUser();
    if($user->hasAsignacion(UserTable::BODEGA1)){
      header('location: /list/product');
      exit();
    }else if($user->hasAsignacion(UserTable::BODEGA2)){
      header('location: /list/product2');
      exit();
    }else if($user->hasPermission(UserTable::ADMIN)){
      header('location: /inicio/administrado');
      exit();
    }
    
    
  }
?>

 <?php if(isset($error)): ?>
  <p class="error"><?= $error ?></p>
  <?php
   endif ; ?>
<div class = "content">
        <h1>Ingresar</h1>
        <form action="" method="POST">
            <label for="username">Usuario: </label>
            <br>
            <input type="text" name="username" placeholder="Ingresa su usuario :" required>
            <br>
            <label for="pass">Contraseña: </label>
            <br>
            <input type="password" name="password" placeholder="Ingresa su contraseña :" required>
            <br>
            <input type="submit" value="Ingresar">
        </form>
        
    </div>


    
