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
                          <select onchange="cambiaNumeroDeRegistrosPorPagina(this)" data-ref="<?php echo base_url().'dashboard_usuarios';?>" class="form-control">
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
                    <a class="btn btn-primary btn-lg" onclick="abreNuevaUsuario(this,event);"><i class="fas fa-plus"></i>&nbsp;Nuevo</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center" style="width:7%;">#</th>
                    <th class="text-center">nombre</th>
                    <th class="text-center">clave_acceso</th>
                    <th class="text-center" style="width:30%;">informacion personal</th>
                    <th class="text-center">rol</th>
                    <th class="text-center" style="width:20%">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($usuarios as $index=>$usuario){
                            echo '<tr>';
                            echo '<td class="text-center">'.((($pagina_seleccionada-1)*$num_filas_por_pagina)+$index+1).'</td>';
                            echo '<td class="text-center">'.$usuario["nombre"].'</td>';
                            echo '<td class="text-truncate text-center">'.$usuario["clave_acceso"].'</td>';
                            echo '<td class="text-truncate text-left">'.$usuario["persona_apellidos"].' '.$usuario["persona_nombres"].'</td>';
                            echo '<td class="text-truncate text-center">'.$usuario["rol_denominacion"].'</td>';
                            echo '<td class="text-center">
                                    <a class="btn btn-light" data-id="'.$usuario["id"].'" onclick="abreVerUsuario(this,event)"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-light" data-id="'.$usuario["id"].'" onclick="abreEditarUsuario(this,event)"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-light" data-id="'.$usuario["id"].'" onclick="abreEliminarUsuario(this,event)"><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                      ?>
                  </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                      <?php
                          $D=$total_usuarios_sin_filtro;
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
                                  echo '<li class="page-item active"><a class="page-link" href="'.base_url().'dashboard_usuarios?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }else{
                                  echo '<li class="page-item"><a class="page-link" href="'.base_url().'dashboard_usuarios?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
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
        function abreNuevaUsuario(bt,event){
          
            $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '50%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    confirm=self;
                    filesUpload=null;
                    return $.post("usuarios/abrir_nuevo")
                    .done(function(data){
                        
                        var r=JSON.parse(data);
                        self.setTitle(r.title);
                        self.setContentAppend(r.template);
                        //hide_loadingOverlay(bt);
                    });
                },
                onContentReady:function(){
                    var self=this;
                    this.$content.find('button[role=busqueda_por_dni]').click(function(){
                        var bt=this;
                        show_loadingOverlay(bt,[255,255,255,0,0.5]);
                        var documento_numero=self.$content.find('input[name=documento_numero]').val();
                        $.post("personas/busqueda_por_dni",{"dni":documento_numero}
                        ).done(function(data){
                            var r=JSON.parse(data);
                            self.$content.find('input[name=nombres]').val(r.nombres);
                            self.$content.find('input[name=apellidos]').val(r.apellidoPaterno+" "+r.apellidoMaterno);
                            hide_loadingOverlay(bt);
                        });
                    });
                    this.$content.find('select[name=documento_tipo]').on('change',function(){
                        var select=this;
                        if($(select).val()==1){
                          self.$content.find('input[name=nombres]').attr('readonly', true);
                          self.$content.find('input[name=apellidos]').attr('readonly', true);
                          self.$content.find('input[name=documento_numero]').parent().find('.input-group-append').removeClass('d-none');
                            self.$content.find('input[name=nombres]').val("");
                            self.$content.find('input[name=apellidos]').val("");
                            
                        }else{
                          if(self.$content.find('input[name=documento_numero]').parent().hasClass('input-group')){
                            self.$content.find('input[name=documento_numero]').parent().find('.input-group-append').addClass('d-none');
                            self.$content.find('input[name=documento_numero]').val("");
                            self.$content.find('input[name=nombres]').val("");
                            self.$content.find('input[name=apellidos]').val("");
                            self.$content.find('input[name=nombres]').removeAttr('readonly');
                            self.$content.find('input[name=apellidos]').removeAttr('readonly');
                          }
                        }
                    });
                    this.$content.find('a[role=guardar]').click(function(){ 
                            var bt=this;
                            $(bt).html("Guardando registro...");
                            show_loadingOverlay(bt,[255,255,255,0,0.5]);
                            var form=$("#formulario_nuevo_usuario");                           
                            $.post('usuarios/guardar_nuevo',$(form).serializeArray()
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
        function abreVerUsuario(bt,event){
          $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("usuarios/abrir_ver",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      //hide_loadingOverlay(bt);
                  });
              }
            });
        }
        function abreEditarUsuario(bt,event){
            $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("usuarios/abrir_editar",{"id":$(bt).attr("data-id")})
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
                      $.post('usuarios/guardar_editar',$(form).serializeArray()
                        ).done(function(data){
                          var r=JSON.parse(data);
                          location.reload();
                        });
                    } else{
                        var ref=firebase.storage().ref();
                        var cat_name=self.$content.find('input[name=denominacion_por_grupo]').val();
                        var name='establecimiento/'+self.$content.find('input[name=establecimiento_id]').val()+'/usuarios/'+(cat_name); 
                        const metadata={
                          contentType:filesUpload.type
                        }
                        const task=ref.child(name).put(filesUpload,metadata);
                        task
                          .then(snapshot=>snapshot.ref.getDownloadURL())
                          .then(url=>{
                              self.$content.find('input[name=imagen_url_to_change]').val(url);
                              var form=self.$content.find('form');
                              $.post('usuarios/guardar_editar',$(form).serializeArray()
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
        function abreEliminarUsuario(bt,event){
            $.confirm({
                title: '<b>Confirme lo siguiente:</b>',
                content:'Realmente desea eliminar la usuario:<br> <b>'+$(bt).attr('data-denominacion')+'</b>',
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
                          $.post('usuarios/eliminar',{"id":$(bt).attr('data-id')}
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                });
                        }).catch(function(error) {
                          $.post('usuarios/eliminar',{"id":$(bt).attr('data-id')}
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