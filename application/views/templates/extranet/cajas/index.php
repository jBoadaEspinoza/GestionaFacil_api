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
                          <select onchange="cambiaNumeroDeRegistrosPorPagina(this)" data-ref="<?php echo base_url().'dashboard_cajas';?>" class="form-control">
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
                    <a class="btn btn-primary btn-lg" onclick="abreNuevaCaja(this,event);"><i class="fas fa-plus"></i>&nbsp;Nuevo</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center" style="width:7%;">#</th>
                    <th class="text-center">Denominación</th>
                    <th class="text-center" style="width:7%;">activo</th>
                    <th class="text-center" style="width:35%;">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($cajas as $index=>$caja){
                            
                            echo '<tr>';
                            echo '<td class="text-center">'.((($pagina_seleccionada-1)*$num_filas_por_pagina)+$index+1).'</td>';
                            echo '<td class="text-truncate">'.$caja["denominacion"].'</td>';
                            echo '<td class="text-center">'.(($caja["activo"]==1) ? 'Si' : 'No').'</td>';
                            echo '<td class="text-center d-flex justify-content-center">';
                                    if($caja["aperturado"]==1){
                                        echo '<a class="btn btn-success d-none"  data-id="'.$caja["id"].'" onclick="abreAperturarCaja(this,event)">Apeturar caja&nbsp;</a>&nbsp;';
                                        echo '<a class="btn btn-danger"  data-id="'.$caja["id"].'" data-denominacion="'.$caja["denominacion"].'" onclick="cerrarCaja(this,event)">&nbsp;&nbsp;&nbsp;Cerrar caja&nbsp;&nbsp;&nbsp;</a>&nbsp;';
                                    }else{
                                        echo '<a class="btn btn-success"  data-id="'.$caja["id"].'" onclick="abreAperturarCaja(this,event)">Apeturar caja&nbsp;</a>&nbsp;';
                                        echo '<a class="btn btn-danger d-none"  data-id="'.$caja["id"].'" data-denominacion="'.$caja["denominacion"].'" onclick="cerrarCaja(this,event)">&nbsp;&nbsp;&nbsp;Cerrar caja&nbsp;&nbsp;&nbsp;</a>&nbsp;';
                                    }
                            echo '<a class="btn btn-light" data-id="'.$caja["id"].'" onclick="abreVerCaja(this,event)"><i class="fas fa-eye"></i></a>&nbsp;
                                    <a class="btn btn-light" data-id="'.$caja["id"].'" onclick="abreEditarCaja(this,event)"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                                    <a class="btn btn-light" data-id="'.$caja["id"].'" onclick="abreEliminarCaja(this,event)"><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                      ?>
                  </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                      <?php
                          $D=$total_cajas_sin_filtro;
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
                                  echo '<li class="page-item active"><a class="page-link" href="'.base_url().'dashboard_cajas?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }else{
                                  echo '<li class="page-item"><a class="page-link" href="'.base_url().'dashboard_cajas?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
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
        function cerrarCaja(bt,event){
          $.confirm({
                title: '<b>Confirme lo siguiente:</b>',
                content:'Realmente desea cerrar la <b>'+$(bt).attr('data-denominacion')+'</b>',
                buttons:{
                  si: {
                      text: 'Si',
                      btnClass: 'btn-danger', 
                      keys: ['enter'],
                      action: function(){
                        $.post('cajas/cierre_caja',{"caja_id":$(bt).attr('data-id')}
                            ).done(function(data){
                              var r=JSON.parse(data);
                              if(r.success){
                                alert(r.msg);
                                window.open("cajas/cierre_ticket?lote="+r.lote,"_blank");
                                location.reload();
                                return;
                              }
                              alert(r.msg);
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
        function abreAperturarCaja(bt,event){
          $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '50%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    confirm=self;
                    return $.post("cajas/apertura_caja",{"caja_id":$(bt).attr('data-id')})
                    .done(function(data){
                        var r=JSON.parse(data);
                        self.setTitle(r.title);
                        self.setContentAppend(r.template);
                    });
                },
                onContentReady:function(){
                    var self=this;
                    this.$content.find('a[role=guardar]').click(function(){ 
                        var bt=this;
                        $(bt).html("Guardando registro...");
                        show_loadingOverlay(bt,[255,255,255,0,0.5]);                           
                        var form=self.$content.find('form');
                        $.post('cajas/guardar_apertura_caja',$(form).serializeArray()
                          ).done(function(data){
                            var r=JSON.parse(data);
                            if(!r.success){
                              var form=self.$content.find('#formulario_apertura_caja');
                              switch(r.msg_id){
                                case 1:
                                  $(form).find('p[role=monto_inicial]').html(r.msg);
                                  $(form).find('input[name=monto_inicial]').focus();
                                  break;
                                case 2:
                                  alert(r.msg);
                                 break;
                              }
                              $(bt).html('<i class="far fa-save"></i>&nbsp;Guardar cambios');
                              hide_loadingOverlay(bt);
                              return;
                            }
                            location.reload();
                          });
                    });
                    this.$content.find('a[role=cancel]').click(function(){
                        self.close();
                    });
                }
            });
        }
        function abreNuevaCaja(bt,event){
            $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '50%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    confirm=self;
                    return $.post("cajas/abrir_nuevo")
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
                        $.post('cajas/guardar_nuevo',$(form).serializeArray()
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
        function abreVerCaja(bt,event){
          $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("cajas/abrir_ver",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      //hide_loadingOverlay(bt);
                  });
              }
            });
        }
        function abreEditarCaja(bt,event){
            $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("cajas/abrir_editar",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      //hide_loadingOverlay(bt);
                  });
              },
              onContentReady:function(){
                var self=this;
                this.$content.find('a[role=imagen]').on('click',function(event){
                    event.preventDefault();
                    self.$content.find('input[type=file]').click();
                });
                this.$content.find('input[type=file]').on('change',function(e){
                    e.preventDefault();
                    var input=this;
                    var img=$(input).parent().parent().find('img');
                    if(input.files && input.files[0]){
                          var reader=new FileReader();
                          reader.readAsDataURL(input.files[0]);
                          filesUpload=e.target.files[0];
                          reader.onload = function (e) {
                            $(img).attr('src',e.target.result);
                            $(input).parent().find('input[name=imagen_url_state]').val("changed");
                        }
                      }
                });
                this.$content.find('a[role=guardar]').click(function(){                            
                    var form=self.$content.find('form');
                    var bt=this;
                    $(bt).html("Actualizando registro...");
                    show_loadingOverlay(bt,[255,255,255,0,0.5]);
                    if(self.$content.parent().find('input[name=imagen_url_state]').val()!="changed"){
                      $.post('cajas/guardar_editar',$(form).serializeArray()
                        ).done(function(data){
                          var r=JSON.parse(data);
                          location.reload();
                        });
                    } else{
                        var ref=firebase.storage().ref();
                        var cat_name=self.$content.find('input[name=denominacion_por_grupo]').val();
                        var name='establecimiento/'+self.$content.find('input[name=establecimiento_id]').val()+'/cajas/'+(cat_name); 
                        const metadata={
                          contentType:filesUpload.type
                        }
                        const task=ref.child(name).put(filesUpload,metadata);
                        task
                          .then(snapshot=>snapshot.ref.getDownloadURL())
                          .then(url=>{
                              self.$content.find('input[name=imagen_url_to_change]').val(url);
                              var form=self.$content.find('form');
                              $.post('cajas/guardar_editar',$(form).serializeArray()
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                });
                          });
                    }   
                });
                this.$content.find('a[role=cancel]').click(function(){
                    self.close();
                });
              }
            });
        }
        function abreEliminarCaja(bt,event){
            $.confirm({
                title: '<b>Confirme lo siguiente:</b>',
                content:'Realmente desea eliminar la caja:<br> <b>'+$(bt).attr('data-denominacion')+'</b>',
                buttons:{
                  si: {
                      text: 'Si',
                      btnClass: 'btn-danger', 
                      keys: ['enter'],
                      action: function(){
                        var ref=firebase.storage().ref();
                        const task=ref.child($(bt).attr('data-ruta')).delete();
                        task
                        .then(function() {
                          $.post('cajas/eliminar',{"id":$(bt).attr('data-id')}
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                });
                        }).catch(function(error) {
                          $.post('cajas/eliminar',{"id":$(bt).attr('data-id')}
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                });
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