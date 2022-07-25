<?php if(isset($alert)){
    echo $alert;
} ?>
<div class="container"><h1>Lista Productos - Materiales</h1>
<h2>Has ingresado como:<?= $user->cargo ?> </h2>
</div>
<div class="table-product">
        <table id="table-principal">
            <thead>
            <tr>
                <th scope="col">Num.</th>
                <th class="ancho1"scope="col">Producto</th>
                <th class="ancho" scope="col">Descripción</th>
                <th scope="col">Cant.</th>
                <th scope="col">Valor de medida</th>
                <th scope="col">Editar</th>
                <th scope="col">Activo/Inactivo</th>
                <!-- <th scope="col">Egreso</th> -->
            </tr>
            </thead>
            <tbody>
                <?php
                $idpro = 1;
                foreach ($productos as $producto): ?>
                    <tr <?php if($producto->amount <=5){
                            echo "data-report";
                        }  ?>  class="<?php if($producto->estado != 0 && $producto->estado != null ){
                                    echo 'inactiva';
                        } ?>">
                        <td scope="row"><?=  $idpro ?? 'vacio' ?></td>
                        <td class="ancho1"><?=  $producto->proname ?? 'vacio' ?></td>
                        <td class="ancho"><?=  $producto->descripcion ?? 'vacio' ?></td>
                        <td><?=  $producto->amount ?? 'vacio' ?></td>
                        <td class="timeregis"><?=  $producto->medida ?? 'desconocido' ?></td>
                        <td class="modify  <?php if($producto->estado != 0 && $producto->estado != null ){
                                    echo 'sin-cursor';
                        } ?>"><a name="edit" id="editProduct" class="bfix" href="/edit/product?id=<?=  $producto->id ?? 'vacio' ?>&bodega=1" role="button">
                                Editar
                            </a></td>
                            <td class="activar-desactivar">
                            <input type="checkbox"<?php if($producto->estado != 0 && $producto->estado != null ){
                                    echo 'checked';
                        } ?>  name="opction" id="activo-inactivo<?=$idpro?>">
                                <label for="activo-inactivo<?=$idpro?>">Activo</label>
                                <input type="hidden" name="id" value="<?= $producto->id ?>">
                            </td>
                        <!-- <td class="modify"><a name="id" id="" class="bfix" href="/egreso/product?id=<?=  $producto->id ?? 'vacio' ?>" role="button">
                                Egreso
                            </a></td> -->
                    </tr>
                <?php
                    $idpro++;
                endforeach;
                 ?>
            </tbody>
        </table>
        <br>
        <div class="addproduct  hide" id="addNewProduct">
        </div>
        <div class="fixproduct" id="editProductList">
        
    </div>
    </div>

    <div class="presentacion-stock hide"id="presentacion-stock"></div>
    <div id="div_histoirial"></div>