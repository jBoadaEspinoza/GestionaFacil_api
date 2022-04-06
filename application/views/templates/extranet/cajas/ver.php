<form class="container-fluid" id="formulario_ver_categoria">
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
                        <input type="text" readonly name="denominacion_por_unidad" value="<?php echo $categoria["denominacion_por_unidad"];?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Denominación por grupo</label>
                        <input type="text" readonly name="denominacion_por_grupo" value="<?php echo $categoria["denominacion_por_grupo"];?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" readonly name="descripcion" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-5 d-flex flex-column bd-highlight mb-3">
                    <img class="img-fluid" style="width:100%;height:300px;" src="<?php echo $categoria["imagen_url"];?>">
                </div>
            </div>
        </div>
    </div>
</form>
