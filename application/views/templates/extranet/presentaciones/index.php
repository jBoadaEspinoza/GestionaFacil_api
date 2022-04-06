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
                          <select onchange="cambiaNumeroDeRegistrosPorPagina(this)" data-ref="<?php echo base_url().'dashboard_presentaciones';?>" class="form-control">
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
                    <a class="btn btn-primary btn-lg" onclick="abreNuevaPresentacion(this,event);"><i class="fas fa-plus"></i>&nbsp;Nuevo</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center" style="width:5%;">#</th>
                    <th class="text-center">denominacion</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($presentaciones as $index=> $presentacion){
                            echo '<tr>';
                            echo '<td class="text-center">'.((($pagina_seleccionada-1)*$num_filas_por_pagina)+$index+1).'</td>';
                            echo '<td class="text-truncate">'.$presentacion["denominacion"].'</td>';
                      
                            echo '<td class="text-center">
                                    <a class="btn btn-light" data-id="'.$presentacion["id"].'" onclick="abreVerPresentacion(this,event)"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-light" data-id="'.$presentacion["id"].'" onclick="abreEditarPresentacion(this,event)"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-light" data-id="'.$presentacion["id"].'" data-denominacion="'.strtoupper($presentacion["denominacion"]).'" onclick="abreEliminarPresentacion(this,event)"><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                      ?>
                  </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                      <?php
                          $D=$total_presentaciones_sin_filtro;
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
                                  echo '<li class="page-item active"><a class="page-link" href="'.base_url().'dashboard_presentaciones?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }else{
                                  echo '<li class="page-item"><a class="page-link" href="'.base_url().'dashboard_presentaciones?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
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
        function abreNuevaPresentacion(bt,event){
            $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '50%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    confirm=self;
                   
                    return $.post("presentaciones/abrir_nuevo")
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
                            $.post('presentaciones/guardar_nuevo',$(form).serializeArray()
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
        function abreVerPresentacion(bt,event){
          $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("presentaciones/abrir_ver",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      //hide_loadingOverlay(bt);
                  });
              }
            });
        }
        function abreEditarPresentacion(bt,event){
            $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("presentaciones/abrir_editar",{"id":$(bt).attr("data-id")})
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
                    var form=self.$content.find('form');
                    var bt=this;
                    $(bt).html("Actualizando registro...");
                    show_loadingOverlay(bt,[255,255,255,0,0.5]);
                    $.post('presentaciones/guardar_editar',$(form).serializeArray()
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
        function abreEliminarPresentacion(bt,event){
            $.confirm({
                title: '<b>Confirme lo siguiente:</b>',
                content:'Realmente desea eliminar la presentacion:<br> <b>'+$(bt).attr('data-denominacion')+'</b>',
                buttons:{
                  si: {
                      text: 'Si',
                      btnClass: 'btn-danger', 
                      keys: ['enter'],
                      action: function(){
                        $.post('presentaciones/eliminar',{"id":$(bt).attr('data-id')}
                          ).done(function(data){
                            var r=JSON.parse(data);
                            location.reload();
                          });
                      }
                  },
                  no: {
                      text: 'No',
                      btnClass: 'btn-light', 
                      keys: ['esc'],
                      action: function(){
                      }
                  },
                },
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