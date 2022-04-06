<form class="container-fluid" id="formulario_nueva_insumo_principal_marca">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $insumoPrincipalMarca["id"];?>" readonly />
                                <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tipos:</label>
                                <select name="tipo" class="form-control">
                                    <?php 
                                        echo '<option value="0">Seleccione una opcion</option>';
                                        foreach($tipos as $index=>$tipo){
                                            if($insumoPrincipalMarca["tipo_id"]==$tipo["id"]){
                                                echo '<option selected value="'.$tipo["id"].'">'.$tipo["denominacion"].'</option>';
                                            }else{
                                                echo '<option value="'.$tipo["id"].'">'.$tipo["denominacion"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Denominacion:</label>
                                <input type="text" name="denominacion" class="form-control" value="<?php echo $insumoPrincipalMarca["denominacion"];?>"/>
                            </div>
                        </div>
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