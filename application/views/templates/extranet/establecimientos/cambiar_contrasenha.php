<form class="container-fluid" id="formulario_cambiar_contrasenha" autocomplete="off" action="<?php echo base_url().'establecimientos/guardar_nueva_contrasenha';?>">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Actual</label>
                <input type="password" autofocus name="actual" class="form-control" />
                <p role="error_actual" class="text-danger"></p>
            </div>
            <div class="form-group">
                <label>Nueva</label>
                <input type="password" name="nueva" class="form-control" />
                <p role="error_nueva" class="text-danger"></p>
            </div>
            <div class="form-group">
                <label>Repetir contraseña nueva</label>
                <input type="password" name="repetir" class="form-control" />
                <p role="error_repetir" class="text-danger"></p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a role="guardar"  class="btn btn-outline-danger"><i class="far fa-save"></i>&nbsp;Guardar cambios</a>&nbsp;
                <a role="cancel" class="btn btn-light">Cancelar</a>
            </div>
        </div>
    </div>
</form>

