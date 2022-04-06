<form class="container-fluid" id="formulario_nueva_categoria">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
            </div>
            <div class="form-group">
                <label>Denominación por unidad</label>
                <input type="text" name="denominacion_por_unidad" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Denominación por grupo</label>
                <input type="text" name="denominacion_por_grupo" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="hidden" name="url" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" rows="2"></textarea>
            </div>
            <div class="form-group d-flex flex-row">
                <input accept="image/*" type="file" name="imagen" class="d-none" />
                <div role="imagen" class="col-3 d-flex flex-column border border-primary text-center">
                    <i class="text-primary fas fa-plus-circle fa-3x pt-4"></i>
                    <label class="text-primary">Agregar imagen</label>
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