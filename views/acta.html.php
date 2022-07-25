<div class="">
    <button  class="button-generate-acta-final" id="button-generate-acta-final">
        Generar PDF
    </button>
</div>
<div class="frame-acta" id="acta-final">
    <div class="acta-title">
        Acta de Entrega Nº <?= $codigo ?>
    </div>
    <div class="acta-notificacion">
        
    </div>
    <div class="acta-items">
        <li> <b>ENTREGADO POR: </b><?= $user->username ?>
                <p><?php ?></p>
        </li>
        <li> <b>RECIBIDO POR: </b><?= $receptor->nombre . ' ' . $receptor->apellido  ?>
                <P><?= $receptor->cargo ?></p>
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
                <?php
                $i = 0;
                 foreach($productos as $product): ?>
                    <tr class="td-altura">
                    <td> <?= $cantidades[$i] ?>  </td>  
                     <td> <?= $product->proname ?? '' ?>  </td>
                    <td> <?= $product->descripcion ?? '' ?>  </td>
                    <td><?= $date->format('Y-m-d') ?> </td>
                    </tr>
                <?php
                $i++;
            endforeach; ?>
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
                <?= $user->username ?>
                <br>
                <?= $user->cargo ?>
            </p>
        </section>
        <section>
            <header> RECIBE CONFORME </header>
            <p>
                <?= $receptor->nombre . ' ' . $receptor->apellido  ?>
                <br>
                <?= $receptor->cargo  ?>
                <?php ?>
            </p>
        </section>
    </div>
</div>
