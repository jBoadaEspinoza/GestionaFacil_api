<form class="container-fluid" id="formulario_nueva_categoria">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="form-group">
                    <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
                    <input type="hidden" name="denominacion" readonly value="<?php echo $denominacion;?>" />
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Categoria&nbsp;<a class="btn btn-link" role="btn-agregar-nueva-categoria" href="categorias/abrir_nuevo">[Agregar nuevo]</a></label>
                        <select name="categoria" class="form-control">
                            <?php 
                                foreach($categorias as $index=>$categoria){
                                    if($categoria_id_seleccionada==$categoria["id"]){
                                        echo '<option selected value="'.$categoria["id"].'">'.$categoria["denominacion_por_unidad"].'</option>';
                                    }else{
                                        echo '<option value="'.$categoria["id"].'">'.$categoria["denominacion_por_unidad"].'</option>';
                                    }
                                   
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Producto o insumo principal&nbsp;<a class="btn btn-link">[Agregar nuevo]</a></label>
                        <select name="producto" class="form-control">
                            <?php 
                                foreach($productos as $index=>$producto){
                                    echo '<option value="'.$producto["id"].'">'.$producto["denominacion"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Presentacion&nbsp;<a class="btn btn-link">[Agregar nuevo]</a></label>
                        <select name="presentacion" class="form-control">
                            <?php 
                                foreach($presentaciones as $index=>$presentacion){
                                    echo '<option value="'.$presentacion["id"].'">'.$presentacion["denominacion"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="p-2">Preposición</label>
                        <select name="preposicion" class="form-control">
                            <?php 
                                foreach($preposiciones as $index=>$preposicion){
                                    echo '<option value="'.$preposicion["id"].'">'.$preposicion["denominacion"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Precio de venta (Soles)</label>
                        <input type="text" name="precio" class="form-control"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="text" name="stock" value="15" class="form-control"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Tiempo de despacho</label>
                        <input type="text" name="tiempo_despacho_min" value="15" class="form-control"/>
                    </div>
                </div>
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