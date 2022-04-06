<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between">
                  <div class="col-4">
                      <div class="form-group">
                          <label>Número de registros por página</label>
                          <select onchange="cambiaNumeroDeRegistrosPorPagina(this)" data-ref="<?php echo base_url().'dashboard_insumos_principales_marcas';?>" class="form-control">
                              <?php
                                $items=[10,25,50,100];
                                for($i=0;$i<count($items);$i++){
                                  if($items[$i]==$num_filas_por_pagina){
                                    echo '<option value="'.$items[$i].'" selected>'.$items[$i].' registros</option>';
                                  }else{
                                    echo '<option value="'.$items[$i].'">'.$items[$i].' registros</option>';
                                  }
                                }
                              ?>
                          </select>
                      </div>
                  </div>
                  <div>
                    <a class="btn btn-primary btn-lg" onclick="abreNuevoInsumosPrincipalesMarca(this,event);"><i class="fas fa-plus"></i>&nbsp;Nuevo</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center" style="width:5%;">#</th>
                    <th class="text-center" style="width:20%;">Tipo</th>
                    <th class="text-center" >Denominacion</th>
                    <th class="text-center" style="width:20%;">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($insumosPrincipalesMarcas as $index=>$m){
                            echo '<tr>';
                            echo '<td class="text-center">'.((($pagina_seleccionada-1)*$num_filas_por_pagina)+$index+1).'</td>';
                            echo '<td class="text-center">'.ucwords(APIS::getInsumosTipo($m["tipo_id"])["denominacion"]).'</td>';
                            echo '<td class="text-left">'.$m["denominacion"].'</td>';
                            echo '<td class="text-center">
                                    <a class="btn btn-light" data-id="'.$m["id"].'" onclick="abreVerInsumosPrincipalesMarca(this,event)"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-light" data-id="'.$m["id"].'" onclick="abreEditarInsumosPrincipalesMarca(this,event)"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-light" data-id="'.$m["id"].'" onclick="abreEliminarInsumosPrincipalesMarca(this,event)"><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                      ?>
                  </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                      <?php
                          $D=$total_insumos_principales_marcas_sin_filtro;
                          $d=$num_filas_por_pagina;
                          $q=intval($D/$d);
                          $r=$D-$d*$q;
                          if($q!=0){
                              echo '<nav aria-label="...">';
                              echo '  <ul class="pagination">';
                              if($r>0){
                                $q=$q+1;
                              }
                              for($i=0;$i<$q;$i++){
                                if(($i+1)==$pagina_seleccionada){
                                  echo '<li class="page-item active"><a class="page-link" href="'.base_url().'dashboard_insumos_principales_marcas?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }else{
                                  echo '<li class="page-item"><a class="page-link" href="'.base_url().'dashboard_insumos_principales_marcas?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }   
                              }
                              echo '  </ul>';
                              echo '</nav>';
                          }
                      ?>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        filesUpload;
        function capitalizeFirstLetter(string) {
          return string.charAt(0).toUpperCase() + string.slice(1);
        }
        function abreNuevoInsumosPrincipalesMarca(bt,event){
            $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '70%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    return $.post("insumosprincipalesmarcas/abrir_nuevo")
                    .done(function(data){
                        var r=JSON.parse(data);
                        self.setTitle(r.title);
                        self.setContentAppend(r.template);
                        //hide_loadingOverlay(bt);
                    });
                },
                onContentReady:function(){
                    var self=this;
                    this.$content.find('a[role=guardar]').click(function(){ 
                            var bt=this;
                            $(bt).html("Guardando registro...");
                            show_loadingOverlay(bt,[255,255,255,0,0.5]);                           
                            var form=self.$content.find('form');
                            $.post('insumosprincipalesmarcas/guardar_nuevo',$(form).serializeArray()
                              ).done(function(data){
                                var r=JSON.parse(data);
                                location.reload();
                              });
                    });
                    this.$content.find('a[role=cancel]').click(function(){
                        self.close();
                    });
                }
            });
        }
        function abreEditarInsumosPrincipalesMarca(bt,event){
            $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '80%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  // show_loadingOverlay(bt,[255,255,255,0,0.5]);
                  return $.post("insumosprincipalesmarcas/abrir_editar",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      // hide_loadingOverlay(bt);
                  });
              },
              onContentReady:function(){
                var self=this;
                this.$content.find('a[role=guardar]').click(function(){                            
                    var form=self.$content.find('form');
                    var bt=this;
                    $(bt).html("Actualizando registro...");
                    show_loadingOverlay(bt,[255,255,255,0,0.5]);
                    $.post('insumosprincipalesmarcas/guardar_editar',$(form).serializeArray()
                      ).done(function(data){
                        var r=JSON.parse(data);
                        hide_loadingOverlay(bt);
                        location.reload();
                    });
                });
                this.$content.find('a[role=cancel]').click(function(){
                    self.close();
                });
              }
            });
        }
        function cambiaNumeroDeRegistrosPorPagina(sel){
           var ref=$(sel).attr('data-ref');
           location.href = ref+'?rows='+$(sel).val();
        }
    </script>
    <style>
      .table {
          table-layout: fixed;
      }
    </style>