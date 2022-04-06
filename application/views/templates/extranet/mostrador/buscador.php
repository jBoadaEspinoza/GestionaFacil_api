<form class="container-fluid" onsubmit="event.preventDefault()" autocomplete="off" id="formulario_buscar_producto">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Busqueda por:</label>
                <select class="form-control" name="busqueda_por">
                    <?php 
                     foreach($busqueda_por as $index=>$c){
                        echo '<option value="'.$c["id"].'">'.ucfirst($c["denominacion"]).'</option>';
                     }
                     ?>
                </select>
            </div>
            <div class="form-group">
                <label>Filtro</label>
                <input type="text" autocomplete="off" name="filtro" class="form-control" value="" />
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 table-responsive">
            
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                    <th class="text-center">Descripcion del producto</th>
                    <th class="text-center">Precio Unit.</th>
                    <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($articulos)!=0){
                            foreach($articulos as $index=>$a){
                                echo '<tr>';
                                echo '<td class="text-center">'.$a["denominacion"].'</td>';
                                echo '<td class="text-center">'.number_format($a["denominacion"], 2, '.', '').'</td>';
                                echo '<td class="text-center">
                                        <a class="btn btn-light d-block">Seleccionar</a>
                                    </td>';
                                echo '</tr>';
                            }
                        }else{
                            for($i=0;$i<5;$i++){
                                echo '<tr>';
                                echo '<td class="text-center"></td>';
                                echo '<td class="text-center"></td>';
                                echo '<td class="text-center"></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</form>