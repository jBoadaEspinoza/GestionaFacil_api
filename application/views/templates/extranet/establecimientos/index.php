<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-center">
                  <span class="font-weight-bold mt-1 d-block text-muted">Mi local esta &nbsp;&nbsp;</span> <input id="abierto_cerrado" type="checkbox" onchange="abrirLocal(this,event)" <?php echo $user["business_open"]==1 ? "checked" : "";?> data-toggle="toggle" data-style="ios" data-on="Abierto" data-off="Cerrado" data-onstyle="success" data-offstyle="danger" data-style="slow" data-size="normal">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <h5 class="text-primary">Información del establecimiento</h5>
                    </hr>
                    <div class="col-12">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>RUC</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["business_ruc"];?>" /> 
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Nombre comercial</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["business_name"];?>" /> 
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <h5 class="text-primary">Información del propietario del negocio</h5>
                    </hr>
                    <div class="col-12">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["user_firstname"];?>" /> 
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["user_lastname"];?>" /> 
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Celular</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["user_cellphone"];?>" /> 
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Correo electrónico</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user["user_email"];?>" /> 
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <h5 class="text-primary">Inicio de sesión</h5>
                    <hr class="bg-dark">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-12">
                          <div class="d-flex flex-row">
                            <div class="p-2 d-flex align-items-center">
                              <i class="fas fa-key fa-2x"></i>
                            </div>
                            <div class="p-2 d-flex flex-column">
                              <b>Cambiar contraseña</b>
                              <span>Se recomienda usar una contraseña segura que no uses en ningun sitio</span>
                            </div>
                            <div class="p-2 d-flex align-items-center">
                              <a onclick="cambiarContrasenha(this,event)" href="<?php echo base_url().'establecimientos/abrir_cambiar_contrasenha';?>" class="btn btn-outline-dark">Editar</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <br>
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
   function abrirLocal(input,event){
     event.preventDefault();
     //var texto="¿Realmente desea <b>cerrar</b> el establecimiento?";
     var abierto=0;
     if($(input).is(':checked')){
        //texto='¿Realmente desea <b>abrir</b> el establecimiento?';
        abierto=1;
     }
     $.post('establecimientos/abrir_cerrar',{"abierto":abierto}
              ).done(function(data){
                  var r=JSON.parse(data);
                  //alert(r.msg);
              });
   }
   function cambiarContrasenha(bt,event){
     event.preventDefault();
     $.dialog({
        closeIcon: true,
        type: 'danger',
        typeAnimated: true,
        boxWidth: '40%',
        useBootstrap: false,
        content:function(){
            var self=this;
            return $.post($(bt).attr('href'))
            .done(function(data){
              
                var r=JSON.parse(data);
                self.setTitle(r.title);
                self.setContentAppend(r.template);
            });
        },
        onContentReady:function(){
            var self=this;
            this.$content.find('a[role=guardar]').click(function(){ 
              var form=$("#formulario_cambiar_contrasenha");
              $.post($(form).attr('action'),$(form).serializeArray()
                ).done(function(data){
                   var r=JSON.parse(data);
                   self.$content.find('p').each(function(index){
                     $(this).html("");
                   });
                   if(r.success){
                      alert(r.msg);
                      window.location.href = r.redirect;
                      return;
                   }
                   if(r.msg_id==1){
                     self.$content.find('p[role=error_actual]').html(r.msg);
                     return;
                   }
                   if(r.msg_id==2){
                     self.$content.find('p[role=error_repetir]').html(r.msg);
                     return;
                   }
                   if(r.msg_id==3){
                     self.$content.find('p[role=error_nueva]').html(r.msg);
                     return;
                   }
                });
            });
            this.$content.find('a[role=cancel]').click(function(){
                self.close();
            });
        }
      });
   }
</script>