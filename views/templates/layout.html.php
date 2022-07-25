<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>Página de Registro</title> -->
  <title><?= $title; ?></title>
  <!-- <link rel="icon" href="../........png"> -->
  <link rel="stylesheet" type="text/css" href="/public/css/main.css">
  <link rel="stylesheet" href="/public/css/acta.css">
  <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
</head>

<body>
<div class="header">
        <?php

            use models\UserTable;

    if(isset($_SESSION['user'])): ?>
    <?php if ($user->hasPermission(UserTable::BODEGERO) && $user->hasAsignacion(UserTable::BODEGA1) 
          ||$user->hasAsignacion(UserTable::BODEGA2)
        ): ?>
            <a href="#menu-d"><div class="menu">
        <h3 class="hamburgesa"></h3>
        </div>
        </a>
        <nav id="menu-d" class="menu-navegacion">
        <a  id=""  href="/" role="button">Inicio</a>
          <a id="addNewProovedor" href="">Ingresar Proovedores</a>
          <a  id="aggProduct"  href="" role="button">Agregar Producto</a>
          <a  id="moreStock"  href="" role="button">Aumentar Stock </a>
          <a  id="historiaBodega"  href="" role="button">Historial Egresos </a>
        <button id="generate-pdf-productos" class="generate-pdf-list"> Mirar Stock</button>
      
          <a href="#"class="exit">X</a>
        </nav>
        <?php endif; ?>
    
        <a name="" id="" class="button-logout" href="/salir" role="button">Cerrar Sesión</a>
       
        <?php if ($user->hasPermission(UserTable::BODEGERO) && $user->hasAsignacion(UserTable::BODEGA1) 
          ||$user->hasAsignacion(UserTable::BODEGA2)
        ): ?>

        <?php if($user->hasAsignacion(UserTable::BODEGA1)): ?>
        <a href="/egreso/product" class="regis centrar">Realizar Egreso</a>
        <?php else: ?>
          <a href="/egreso/product2" class="regis centrar">Realizar Egreso</a>
        <?php endif; ?>

        <?php endif; ?>

        <?php endif; ?>
    </div>
  
    <?= $content; ?>
  
  <script src="/public/js/modules/html2pdf.js/dist/html2pdf.bundle.min.js"></script>
  <script src="/public/js/main.js"></script>
</body>

</html>
