<form class="container-fluid" id="formulario_nueva_categoria">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $articulo["id"];?>" readonly />
                                <input type="hidden" name="establecimiento_id" readonly value="<?php echo $user["business_id"];?>" />
                                <input type="hidden" name="denominacion" readonly value="<?php echo $denominacion;?>" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Categoria&nbsp;<a class="btn btn-link">[Agregar nuevo]</a></label>
                                <select name="categoria" class="form-control">
                                    <?php 
                                        foreach($categorias as $index=>$categoria){
                                            if($articulo["categoria_id"]==$categoria["id"]){
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
                                            if($articulo["producto_id"]==$producto["id"]){
                                                echo '<option selected value="'.$producto["id"].'">'.$producto["denominacion"].'</option>';
                                            }else{
                                                echo '<option value="'.$producto["id"].'">'.$producto["denominacion"].'</option>';
                                            }
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
                                            if($articulo["presentacion_id"]==$presentacion["id"]){
                                                echo '<option selected value="'.$presentacion["id"].'">'.$presentacion["denominacion"].'</option>';
                                            }else{
                                                echo '<option value="'.$presentacion["id"].'">'.$presentacion["denominacion"].'</option>';
                                            }
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
                                            if($articulo["preposicion_id"]==$preposicion["id"]){
                                                echo '<option selected value="'.$preposicion["id"].'">'.$preposicion["denominacion"].'</option>';
                                            }else{
                                                echo '<option value="'.$preposicion["id"].'">'.$preposicion["denominacion"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Precio de venta (Soles)</label>
                                <input type="text" name="precio" class="form-control" value="<?php echo $articulo["precio_pen"];?>"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="text" name="stock" class="form-control" value="<?php echo $articulo["stock"];?>"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tiempo de despacho</label>
                                <input type="text" name="tiempo_despacho_min" class="form-control" value="<?php echo $articulo["tiempo_despacho_min"];?>" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="2" value="<?php echo $articulo["descripcion"];?>" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 d-flex flex-column bd-highlight mb-3">
                    <img class="img-fluid" style="width:100%;height:400px;" src="<?php echo $articulo["imagen_url"];?>">
                    <div class="d-flex justify-content-center">
                        <input accept="image/*" type="file" name="imagen" class="d-none"/>
                        <a role="imagen" href="<?php echo $articulo["imagen_url"];?>" class="mt-2 btn btn-dark btn-xs"><i class="far fa-edit"></i>&nbsp;Cambiar imagen</a>
                        <input type="hidden" name="imagen_url_loaded" value="<?php echo $articulo["imagen_url"];?>" />
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