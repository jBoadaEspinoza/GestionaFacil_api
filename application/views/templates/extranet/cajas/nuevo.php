<form class="container-fluid" id="formulario_nueva_caja">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
            </div>
            <div class="form-group">
                <label>Denominación</label>
                <input type="text" name="denominacion" class="form-control"/>
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