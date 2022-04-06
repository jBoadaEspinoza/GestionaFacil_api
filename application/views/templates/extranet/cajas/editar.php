<form class="container-fluid" id="formulario_editar_categoria">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-7">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $categoria["id"];?>" readonly />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="establecimiento_id" value="<?php echo $categoria["establecimiento_id"];?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Denominación por unidad</label>
                        <input type="text" name="denominacion_por_unidad" value="<?php echo $categoria["denominacion_por_unidad"];?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Denominación por grupo</label>
                        <input type="text" name="denominacion_por_grupo" value="<?php echo $categoria["denominacion_por_grupo"];?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-5 d-flex flex-column bd-highlight mb-3">
                    <img class="img-fluid" style="width:100%;height:300px;" src="<?php echo $categoria["imagen_url"];?>">
                    <div class="d-flex justify-content-center">
                        <input accept="image/*" type="file" name="imagen" class="d-none"/>
                        <a role="imagen" href="<?php echo $categoria["imagen_url"];?>" class="mt-2 btn btn-dark btn-xs"><i class="far fa-edit"></i>&nbsp;Cambiar imagen</a>
                        <input type="hidden" name="imagen_url_loaded" value="<?php echo $categoria["imagen_url"];?>" />
                        <input type="hidden" name="imagen_url_state" value="" />
                        <input type="hidden" name="imagen_url_to_change" value="" />
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

