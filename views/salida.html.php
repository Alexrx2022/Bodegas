
<div class="container-admin">
<div class="opciones-admin bajo">
    <form action="" method="post">
        <label for="nombreSolicitante">Escoga al solicitante</label>
        <!-- <input type="text" name="nombre">
        <label for="apellido">Ingrese el apellido del solicitante</label>
        <input type="text" name="apellido"> -->
        <select name="receptor" id="recep-re">
            
            <?php foreach($receptores as $receptor): ?>
                    <?php if($receptor->bodega == 1 || $receptor->bodega == 2): ?>
                    <option value="<?= $receptor->cedula ?>"> <?= $receptor->nombre .' '. $receptor->apellido ?> </option>
                <?php endif; endforeach ?>
        </select>
        <!-- <label for="correo">Ingrese el correo electronico del solicitante</label>
        <input type="email" name="email"> -->
        <!-- <label for="">Selecione el cargo del solicitante</label>
        <select name="" id="">
            <?php //foreach($cargos as $cargo):?>
            <option value="<?php //$cargo; ?>"><?php // $cargo;?></option>
            // endforeach; ?>
        </select> -->
        <!-- <label for="cantidad">Ingrese la cantidad que desea el solicitante</label>
        <input type="number" name="cantidad" min="1" max="">
        <input type="hidden" name="id" value=""> -->
        <div class="varios-productos">
            <h4>Selecione los productos que van a salir con su respectiva cantidad</h4>

            <?php $id =0; foreach($productos as $producto):?>
                <?php if($producto->estado != 1) :?>
                    <?php if(! $producto->amount <= 0): ?>
                <section>
                    <span>
                    <label for=""><?= $producto->proname?></label>
                    <input type="checkbox"  name="productos[]" value="<?= $producto->id ?>" id="input<?= $id?>">
                    </span>
                    <span>
                    <label for="">Cantidad</label>
                    <input type="number" name="cantidad[]" min="1" max="<?= $producto->amount?>" id="<?= $id?>">
                    </span>
                </section>
                <?php endif; ?>
                <?php endif; ?>
            <?php $id++; endforeach; ?>
        </div>
        <button id="generate-egrese">Generar Egreso</button>
        <input type="hidden" value="<?= $user->username ?>" id="nombre-emisor">
    </form>
</div>
        </div>
        </div>
<div id="presentacion-acta" class="pre-acta-carga hide">

</div>
<template id="frame-pre-acta">
<div class="frame-acta" id="acta-final">
    <div class="acta-title">
        Acta de Entrega Nº <span></span>
    </div>
    <div class="acta-notificacion">
        
    </div>
    <div class="acta-items">
        <li> <b>ENTREGADO POR: </b> <span></span>
                <p></p>
        </li>
        <li> <b>RECIBIDO POR: </b> <span></span>
                <P></p>
        </li>
    </div>
    <div class="acta-detalle">
        De los productos que a continuación se detalla:
    </div>
    <div class="acta-tabla">
        <table>
            <thead>
                <tr>
                <th class="acta-tabla-cantidad">CANTIDAD</th>
                    <th class="acta-tabla-descrip">NOMBRE</th>
                    <th class="acta-tabla-descrip ">DESCRIPCIÓN</th>
                    <th class="acta-tabla-descrip ">FECHA DE ENTREGA</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="acta-notificacion-final">
        Para constancia que la entrega se realizó conforme a lo descrito, firman original 
        y una copia las personas anteriores indicadas 
    </div>
    <div class="acta-firmas">
        <section>
            <header> ENTREGUE CONFORME </header>
            <p>
                <span></span>
                <br>
                <!-- CI:-->
            </p>
        </section>
        <section>
            <header> RECIBE CONFORME </header>
            <p>
               <span></span>
                <br>
                
            </p>
        </section>
    </div>
    <div class="opciones-pre-acta">
        <button id="cancel">Cancelar</button><button id="next">Continuar</button>
    </div>
</div>

</template>