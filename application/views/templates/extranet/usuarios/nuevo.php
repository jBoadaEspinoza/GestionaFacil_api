<form class="container-fluid" id="formulario_nuevo_usuario">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
            </div>
            <fieldset class="row scheduler-border">
                <legend class="scheduler-border">Datos de la cuenta</legend>
                <div class="col-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre_usuario" class="form-control"/>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="clave_acceso" class="form-control"/>
                    </div>
                </div>
            </fieldset>
            <fieldset class="row scheduler-border">
                <legend class="scheduler-border">Información personal</legend>
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
                            <input type="text" name="documento_numero" class="form-control"/>
                            <div class="input-group-append">
                                <button class="btn btn-info" role="busqueda_por_dni" type="button">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombres" readonly class="form-control"/>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" readonly class="form-control"/>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Rol</label>
                        <select name="rol" class="form-control">
                            <?php
                                foreach($roles as $index=>$rol){
                                    echo '<option value="'.$rol["id"].'">'.ucfirst($rol["denominacion"]).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <div class="d-flex justify-content-end">
                    <a role="guardar" class="btn btn-outline-danger"><i class="far fa-save"></i>&nbsp;Guardar</a>
                    <a role="cancel" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>