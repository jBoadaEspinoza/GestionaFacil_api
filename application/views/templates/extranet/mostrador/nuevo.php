<form class="container-fluid" id="formulario_nuevo_pedido">
    <div class="row">
        <div class="col-6">
            <div class="d-flex justify-content-start">
                <label class="text-10x mt-1">Total a Pagar:&nbsp;</label>
                <label class="text-10x bg-dark p-2" role="total">
                    <?php 
                        $total=0;
                        if(count($pedidos_detalles)!=0){
                            foreach($pedidos_detalles as $index=>$pd){
                                $total+=$pd["cantidad"]*$pd["precio_unitario_pen"];    
                            }
                        }
                        echo "S/. " . number_format($total, 2, '.', '');
                    ?>
                </label>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-end">
                <?php echo ($pedido_id!=0) ? '<a role="dividir_pago" data-mesa-id="'.$mesa_id.'" data-mesa-denominacion="'.$mesa_denominacion.'" data-pedido-id="'.$pedido_id.'" onclick="dividirPago(this,event)" class="btn btn-outline-dark"><i class="fas fa-cut"></i>&nbsp;Dividir pedido</a>&nbsp;' : ''; ?>
                <?php echo ($pedido_id!=0) ? '<a role="cerrar_pedido" data-mesa-id="'.$mesa_id.'" data-mesa-denominacion="'.$mesa_denominacion.'" data-pedido-id="'.$pedido_id.'" onclick="cerrarPedido(this,event)" class="btn btn-outline-dark"><i class="fas fa-cash-register"></i>&nbsp;Cerrar pedido</a>&nbsp;' : ''; ?>
                <?php echo ($pedido_id!=0) ? '<a role="imprimir_comanda" href="pedidos/comanda?p_id='.$pedido_id.'&m_id='.$mesa_id.'" target="_blank" class="btn btn-outline-dark"><i class="fas fa-print"></i>&nbsp;Comanda</a>&nbsp;' : ''; ?>
                <a role="agregar_articulo" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Producto</a>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Mozo:</label>
                <select class="form-control" name="mozo"  <?php echo ($readonly) ? "disabled" : "" ?>>
                    <?php 
                        
                        foreach($mozos as $index =>$mozo){
                            if(isset($pedido["mozo_id"])){
                                if($pedido["mozo_id"]==$mozo["id"]){
                                    echo '<option selected value="'.$mozo["id"].'">'.$mozo["apellidos"].' '.$mozo["nombres"].'</option>';
                                }else{
                                    echo '<option value="'.$mozo["id"].'">'.$mozo["apellidos"].' '.$mozo["nombres"].'</option>';
                                }
                            }else{
                                echo '<option value="'.$mozo["id"].'">'.$mozo["apellidos"].' '.$mozo["nombres"].'</option>';
                            }
                            
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table id="example2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                <th class="text-center" style="width:15%;">Cantidad</th>
                <th class="text-center">Descripcion del producto</th>
                <th class="text-center" style="width:15%;">Precio Unitario</th>
                <th class="text-center" style="width:15%;">Importe</th>
                <th class="text-center" style="width:15%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($pedidos_detalles)!=0){
                        foreach($pedidos_detalles as $index=>$pd){
                            echo '<tr>';
                            echo '<td class="text-center">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button data-index="'.$index.'" class="btn btn-dark" onclick="agregarQuitarCantidad(this,event)" type="button">+</button>
                                        </div>
                                        <input type="text" class="form-control text-center" name="detalle['.$index.'][cantidad]" readonly value="'.$pd["cantidad"].'" aria-label="" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button data-index="'.$index.'" class="btn btn-dark" onclick="agregarQuitarCantidad(this,event)" type="button">-</button>
                                        </div>                                  
                                    </div>
                                </td>';
                            echo '<td class="text-left" data-articulo-id="'.$pd["articulo_id"].'">'.
                                        '<input type="hidden" readonly name="detalle['.$index.'][articulo_id]" value="'.$pd["articulo_id"].'" />'.
                                        $pd["articulo_denominacion"]
                                .'</td>';
                            echo '<td class="text-center">'.
                                        '<input type="hidden" readonly name="detalle['.$index.'][precio]" value="'.$pd["precio_unitario_pen"].'" />'.
                                        number_format($pd["precio_unitario_pen"], 2, '.', '')
                                .'</td>';
                            echo '<td class="text-center">'.number_format($pd["cantidad"]*$pd["precio_unitario_pen"], 2, '.', '').'</td>';
                            echo '<td class="text-center">
                                    <input type="hidden" readonly class="form-control" name="detalle['.$index.'][descripcion]" value="'.$pd["sugerencias"].'" />     
                                    <a class="btn btn-light" data-index="'.$index.'" role="agregar_descripcion" href="pedidos/agrega_descripcion" onclick="agregaDescripcion(this,event)"><i class="fas fa-folder-plus"></i></a>
                                    <a class="btn btn-light" data-index="'.$index.'" ><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                    }else{
                        for($i=0;$i<5;$i++){
                            echo '<tr>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-left"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <input type="hidden" name="pedido_id"  readonly value="<?php echo $pedido_id;?>"/>
                <input type="hidden" name="mesa_id"  readonly value="<?php echo $mesa_id;?>"/>
                <input type="hidden" name="mesa_denominacion"  readonly value="<?php echo $mesa_denominacion;?>"/>
                <a role="guardar"  class="btn btn-outline-danger disabled"><i class="far fa-save"></i>&nbsp;<?php echo (count($pedidos_detalles)==0) ? "Guardar" : "Actualizar";?></a>&nbsp;
                <a role="cancel" class="btn btn-light">Cancelar</a>
            </div>
        </div>
    </div>
</form>

