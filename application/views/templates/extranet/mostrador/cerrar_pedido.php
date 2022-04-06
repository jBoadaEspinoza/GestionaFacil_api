<form class="container-fluid" onsubmit="event.preventDefault()" autocomplete="off" id="formulario_cerrar_pedido">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="moneda_id" readonly value="<?php echo $moneda_id;?>" />
                <input type="hidden" name="monto" readonly value="<?php echo $monto;?>" />
                <input type="hidden" name="pedido_id" readonly value="<?php echo $pedido_id;?>" />
                <input type="hidden" name="mesa_id" readonly value="<?php echo $mesa_id;?>" />
            </div>
            <div class="form-group">
                <label>Caja aperturada:</label>
                <select name="caja_aperturada" class="form-control">
                    <?php
                        foreach($cajas as $index=>$caja){
                            echo '<option value="'.$caja["id"].'">'.strtoupper($caja["caja_denominacion"].'-'.$caja["persona_apellidos"].' '.$caja["persona_nombres"]).'</option>';
                        } 
                    ?>
                </select>
                <p role="caja_aperturada_error" class="d-none text-danger"></p>
            </div>
        </div>
    </div>
    <fieldset class="row scheduler-border">
        <legend class="scheduler-border">Información del cliente</legend>
        <div class="col-6">
            <div class="form-group">
                <label>Tipo de documento</label>
                <select name="documento_tipo" class="form-control">
                    <?php
                        foreach($documentosTipos as $index=>$documento){
                            echo '<option value="'.$documento["id"].'">'.ucfirst($documento["denominacion_largo_es"]).'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Número de documento</label>
                <div class="input-group">
                    <input type="text" name="documento_numero" autocomplete="off" class="form-control"/>
                    <div class="input-group-append">
                        <button class="btn btn-info" role="busqueda" type="button">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" name="nombres" readonly autocomplete="off" class="form-control"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellidos" readonly autocomplete="off" class="form-control"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Celular</label>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group">
                                <select  class="col-5 form-control" name="postal">
                                <?php
                                   foreach($paises as $index=>$p){
                                       echo '<option value="'.$p["callingCodes"].'">'.ucfirst($p["denominacion_es"]).'(+'.$p["callingCodes"].')</option>';
                                   } 
                                   
                                ?>
                                </select> 
                                <input type="text" name="celular"  autocomplete="off" class="col-7 form-control"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="text" name="correo_electronico" autocomplete="off"  class="form-control"/>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-12">
             <div class="form-group">
                <label>Modalidad de pago:</label>
                <select name="modalidad_pago" class="form-control">
                    <?php
                        foreach($modalidades as $index=>$modalidad){
                            echo '<option value="'.$modalidad["id"].'">'.ucfirst($modalidad["denominacion"]).'</option>';
                        } 
                    ?>
                </select>
            </div> 
            <div class="form-group ">
                <div class="d-flex justify-content-end">
                    <a role="finalizar" class="btn btn-outline-primary"><i class="far fa-save"></i>&nbsp;Finalizar pedido</a>
                    <a role="cancel" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>