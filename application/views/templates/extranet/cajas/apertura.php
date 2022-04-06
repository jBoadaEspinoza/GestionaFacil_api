<form class="container-fluid" id="formulario_apertura_caja">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="caja_id" class="form-control" readonly value="<?php echo $caja["id"];?>" />
                    <div class="form-group">
                        <label>Cajero(a)</label>
                        <select class="form-control" name="cajero">
                            <?php 
                                foreach($cajeros as $index=>$cajero){
                                    echo '<option value="'.$cajero["id"].'">'.ucwords(strtolower($cajero["persona_apellidos"].' '.$cajero["persona_nombres"])).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Monto inicial S/.</label>
                        <input type="text" class="form-control" name="monto_inicial" />
                        <p role="monto_inicial" class="text-danger"></p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group ">
                        <div class="d-flex justify-content-end">
                            <a role="guardar" class="btn btn-outline-danger"><i class="far fa-save"></i>&nbsp;Guardar cambios</a>
                            <a role="cancel" class="btn btn-light">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>