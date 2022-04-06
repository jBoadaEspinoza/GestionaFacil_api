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
                          <select onchange="cambiaNumeroDeRegistrosPorPagina(this)" data-ref="<?php echo base_url().'dashboard_categorias';?>" class="form-control">
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
                    <a class="btn btn-primary btn-lg" onclick="abreNuevaCategoria(this,event);"><i class="fas fa-plus"></i>&nbsp;Nuevo</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Denominación por unidad</th>
                    <th class="text-center">Denominación por grupo</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($categorias as $categoria){
                            echo '<tr>';
                            echo '<td class="text-truncate">'.md5($categoria["id"]).'</td>';
                            echo '<td class="text-truncate">'.$categoria["denominacion_por_unidad"].'</td>';
                            echo '<td class="text-truncate">'.$categoria["denominacion_por_grupo"].'</td>';
                            echo '<td class="text-truncate">'.$categoria["descripcion"].'</td>';
                            echo '<td class="text-truncate text-center"><img class="img-fluid" style="width:30px;height:25px;" src="'.$categoria["imagen_url"].'"></td>';
                            echo '<td class="text-center">
                                    <a class="btn btn-light" data-id="'.$categoria["id"].'" onclick="abreVerCategoria(this,event)"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-light" data-id="'.$categoria["id"].'" onclick="abreEditarCategoria(this,event)"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-light" data-id="'.$categoria["id"].'" data-ruta="establecimiento'.'/'.$categoria["establecimiento_id"].'/'.'categorias'.'/'.$categoria["denominacion_por_grupo"].'" data-denominacion="'.strtoupper($categoria["denominacion_por_unidad"].'/'.$categoria["denominacion_por_grupo"]).'"  data-url="'.$categoria["imagen_url"].'" onclick="abreEliminarCategoria(this,event)"><i class="fas fa-trash-alt"></i></a>
                                </td>';
                            echo '</tr>';
                        }
                      ?>
                  </tbody>
                </table>
                <br>
                <div class="d-flex justify-content-center">
                      <?php
                          $D=$total_categorias_sin_filtro;
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
                                  echo '<li class="page-item active"><a class="page-link" href="'.base_url().'dashboard_categorias?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
                                }else{
                                  echo '<li class="page-item"><a class="page-link" href="'.base_url().'dashboard_categorias?rows='.$d.'&pag='.($i+1).'">'.($i+1).'</a></li>';
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
        function abreNuevaCategoria(bt,event){
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
                    return $.post("categorias/abrir_nuevo")
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
                            if(filesUpload!=null){
                              var ref=firebase.storage().ref();
                              var cat_name=self.$content.find('input[name=denominacion_por_grupo]').val();
                              var name='establecimiento/'+self.$content.find('input[name=establecimiento_id]').val()+'/categorias/'+(cat_name);
                        
                              const metadata={
                                contentType:filesUpload.type
                              }
                              const task=ref.child(name).put(filesUpload,metadata);
                              task
                                .then(snapshot=>snapshot.ref.getDownloadURL())
                                .then(url=>{
                                    self.$content.find('input[name=url]').val(url);
                                    var form=self.$content.find('form');
                                    $.post('categorias/guardar_nuevo',$(form).serializeArray()
                                      ).done(function(data){
                                        var r=JSON.parse(data);
                                        location.reload();
                                      });
                                });
                            }else{
                              var form=self.$content.find('form');
                              $.post('categorias/guardar_nuevo',$(form).serializeArray()
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                }); 
                            }
                    });
                    this.$content.find('a[role=cancel]').click(function(){
                        self.close();
                    });
                    this.$content.find('div[role=imagen]').on('click',function(){
                        self.$content.find('input[type=file]').click();
                    });
                    this.$content.find('input[type=file]').on('change',function(e){
                        e.preventDefault();
                        var input=this;
                        if(input.files && input.files[0]){
                             var reader=new FileReader();
                             reader.readAsDataURL(input.files[0]);
                             filesUpload=e.target.files[0];
                             reader.onload = function (e) {
                                //$('#uploadForm + img').remove()
                                self.$content.find('div[role=imagen]').before('<img class="mr-1 img-thumbnail" src="'+e.target.result+'" style="width:150px;height:150px" />');
                                self.$content.find('div[role=imagen]').remove();
                            }

                         }
                    });
                }
            });
        }
        function abreVerCategoria(bt,event){
          $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("categorias/abrir_ver",{"id":$(bt).attr("data-id")})
                  .done(function(data){
                      var r=JSON.parse(data);
                      self.setTitle(r.title);
                      self.setContentAppend(r.template);
                      //hide_loadingOverlay(bt);
                  });
              }
            });
        }
        function abreEditarCategoria(bt,event){
            $.dialog({
              closeIcon: true,
              type: 'danger',
              typeAnimated: true,
              boxWidth: '60%',
              useBootstrap: false,
              content:function(){
                  var self=this;
                  confirm=self;
                  return $.post("categorias/abrir_editar",{"id":$(bt).attr("data-id")})
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
                      $.post('categorias/guardar_editar',$(form).serializeArray()
                        ).done(function(data){
                          var r=JSON.parse(data);
                          location.reload();
                        });
                    } else{
                        var ref=firebase.storage().ref();
                        var cat_name=self.$content.find('input[name=denominacion_por_grupo]').val();
                        var name='establecimiento/'+self.$content.find('input[name=establecimiento_id]').val()+'/categorias/'+(cat_name); 
                        const metadata={
                          contentType:filesUpload.type
                        }
                        const task=ref.child(name).put(filesUpload,metadata);
                        task
                          .then(snapshot=>snapshot.ref.getDownloadURL())
                          .then(url=>{
                              self.$content.find('input[name=imagen_url_to_change]').val(url);
                              var form=self.$content.find('form');
                              $.post('categorias/guardar_editar',$(form).serializeArray()
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
        function abreEliminarCategoria(bt,event){
            $.confirm({
                title: '<b>Confirme lo siguiente:</b>',
                content:'Realmente desea eliminar la categoria:<br> <b>'+$(bt).attr('data-denominacion')+'</b>',
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
                          $.post('categorias/eliminar',{"id":$(bt).attr('data-id')}
                                ).done(function(data){
                                  var r=JSON.parse(data);
                                  location.reload();
                                });
                        }).catch(function(error) {
                          $.post('categorias/eliminar',{"id":$(bt).attr('data-id')}
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