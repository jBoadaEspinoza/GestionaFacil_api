<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php
                    if ($user["business_open"]==1){
                      echo '<div id="mostrador" class="d-flex flex-wrap">';
                      foreach($mesas as $index=>$mesa){
                          $estado_color="success";
                          
                          if($mesa["estado"]=="ocupado"){
                            $estado_color="danger";
                          }
                          
                          echo '<div data-mesa-id="'.$mesa["id"].'" data-mesa-denominacion="'.$mesa["denominacion"].'" data-referencia-pedido="'.$mesa["referencia_pedido"].'" class="hover col-2 d-flex flex-column" data-id="'.$mesa["id"].'" onclick="MostrarDetalleDeMesa(this,event)">';
                            echo '<img src="'.base_url().'assets\dist\img\table.png" style="height:200px;" class="bg-'.$estado_color.' rounded-circle p-3" alt="...">';
                            echo '<div class="pb-2 text-3x text-center"><b>'.ucfirst($mesa["denominacion"]).'</b></div>';
                          echo '</div>';
                      }
                      echo '</div>';
                    }else{
                      echo '<p class="text-center">El establecimiento se encuentra cerrado</p>';
                    }
                  ?>
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
      var formulario_buscar_articulo;
      var formulario_detalle_mesa;
      var formulario_dividir_pedido;
      function MostrarDetalleDeMesa(el,event){
    
            $.dialog({
                closeIcon: true,
                type: 'danger',
                typeAnimated: true,
                boxWidth: '70%',
                useBootstrap: false,
                content:function(){
                    var self=this;
                    formulario_detalle_mesa=self;
                    return $.post("pedidos/abrir_nuevo",{"ref_ped":$(el).attr('data-referencia-pedido'),"mesa_id":$(el).attr('data-mesa-id'),"mesa_denominacion":$(el).attr('data-mesa-denominacion')})
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
                      var bt=$(this);
                      var form=$("#formulario_nuevo_pedido");
                      $.post("pedidos/guardar_nuevo",$(form).serializeArray()
                        ).done(function(data){
                            var r=JSON.parse(data);
                            if(r.success){
                              if(r.operacion=="inserted"){
                                self.setTitle("Pedido ID:"+r.pedido_id+" | "+r.mesa_denominacion);
                                $(bt).addClass('disabled');
                                self.$content.find('#mostrador').find('div').each(function(index){
                                  if($(this).attr("data-mesa-id")==r.mesa_id){
                                    $(this).attr('data-referencia-pedido')=r.pedido_id;
                                    $(this).find('img').addClass('bg-danger').removeClass('bg-success');
                                  }
                                });
                                alert(r.msg);
                                location.reload();
                                return;
                              }else{
                                alert(r.msg);
                                $(bt).addClass('disabled');
                                //location.reload();
                                return;
                              }
                            }  
                        });
                    });
                    this.$content.find('a[role=dividir_pago]').click(function(){
                      var bt=this;
                      $.dialog({
                        closeIcon:true,
                        type: 'danger',
                          boxWidth: '70%',
                          useBootstrap: false,
                          scrollToPreviousElement:true,
                          content:function(){
                            var self=this;
                            formulario_dividir_pedido=self;
                            return $.post("pedidos/abrir_cortar_cierre_pedido",{"pedido_id":$(bt).attr('data-pedido-id'),"mesa_id":$(bt).attr('data-mesa-id'),"mesa_denominacion":$(bt).attr('data-mesa-denominacion')})
                            .done(function(data){
                              var r=JSON.parse(data);
                              self.setTitle(r.title);
                              self.setContentAppend(r.template);
                            });
                          },
                          onContentReady:function(){
                            var self=this;
                            this.$content.find('button[role=busqueda]').click(function(){
                                  var bt=this;
                                  show_loadingOverlay(bt,[255,255,255,0,0.5]);
                                  var documento_numero=self.$content.find('input[name=documento_numero]').val();
                                  var documento_tipo_id=self.$content.find('select[name=documento_tipo]').val();
                                  $.post("personas/busqueda_por_documento",{"documento_numero":documento_numero,"documento_tipo_id":documento_tipo_id}
                                  ).done(function(data){
                                     alert(data);
                                      var r=JSON.parse(data);
                                      if(!r.success){

                                        self.$content.find('input[name=nombres]').focus();
                                        self.$content.find('input[name=nombres]').val("");
                                        self.$content.find('input[name=apellidos]').val("");
                                        self.$content.find('select[name=postal]').find('option').each(function(){
                                          $(this).removeAttr('selected');
                                           if($(this).val()==51){
                                            $(this).attr('selected','selected');
                                           }
                                        });

                                        self.$content.find('input[name=celular]').val("");
                                        self.$content.find('input[name=correo_electronico]').val("");
                                        self.$content.find('input[name=nombres]').removeAttr('readonly');
                                        self.$content.find('input[name=apellidos]').removeAttr('readonly');
                                        
                                        hide_loadingOverlay(bt);
                                        return;
                                      }

                                      self.$content.find('input[name=nombres]').val(r.nombres);
                                      self.$content.find('input[name=apellidos]').val(r.apellidos);
                                      self.$content.find('input[name=celular]').val(r.celular_numero);
                                      self.$content.find('input[name=correo_electronico]').val(r.correo_electronico);
                                      if(r.return=="from_dni"){
                                        self.$content.find('input[name=nombres]').attr('readonly',true);
                                        self.$content.find('input[name=apellidos]').attr('readonly',true);
                                        self.$content.find('input[name=celular]').focus();
                                      }else{
                                        self.$content.find('input[name=nombres]').removeAttr('readonly');
                                        self.$content.find('input[name=apellidos]').removeAttr('readonly');
                                      } 
                                      self.$content.find('select[name=postal]').find('option').each(function(){
                                        $(this).removeAttr('selected');
                                          if($(this).val()==parseInt(r.celular_numero_postal_id)){
                                            
                                            $(this).attr('selected','selected');
                                          }
                                      });
                                      hide_loadingOverlay(bt);
                                  });
                              });
                            this.$content.find('a[role=finalizar]').click(function(){
                              var form=self.$content.find('form');
                              var bt=this;
                                var form=self.$content.find('form');
                                $(bt).html("cerrando pedido...");
                                show_loadingOverlay(bt,[255,255,255,0,0.5]);
                                                          
                                $.post('pedidos/guardar_dividir_cortar_pedido',$(form).serializeArray()
                                  ).done(function(data){
                                    var r=JSON.parse(data);
                                    if(r.success){
                                      alert(r.msg);
                                      window.open("pedidos/print_ticket?p_id="+r.p_id,"_blank");
                                      location.reload();
                                      return;
                                    }
                                    switch(r.msg_id){
                                      case 1:
                                        self.$content.find('p[role=caja_aperturada_error]').removeClass('d-none');
                                        self.$content.find('p[role=caja_aperturada_error]').html(r.msg);
                                        break;
                                      default:
                                        alert(r.msg);
                                        break;
                                    }
                                    hide_loadingOverlay(bt);
                                    return;
                                  });
                            });
                            this.$content.find('a[role=cancel]').click(function(){
                                  self.close();
                              });
                          }
                      });
                    });
                    this.$content.find('a[role=cerrar_pedido]').click(function(){
                      var bt=this;
                      $.dialog({
                          closeIcon: true,
                          type: 'danger',
                          boxWidth: '60%',
                          useBootstrap: false,
                          scrollToPreviousElement:true,
                          content:function(){
                            var self=this;
                            formulario_cerrar_pedido=self;
                            return $.post("pedidos/abrir_cerrar_pedido",{"pedido_id":$(bt).attr('data-pedido-id'),"mesa_id":$(bt).attr('data-mesa-id'),"mesa_denominacion":$(bt).attr('data-mesa-denominacion')})
                            .done(function(data){
                          
                              var r=JSON.parse(data);
                              self.setTitle(r.title);
                              self.setContentAppend(r.template);
                            });
                          },
                          onContentReady:function(){
                              var self=this;
                              this.$content.find('button[role=busqueda]').click(function(){
                                  var bt=this;
                                  show_loadingOverlay(bt,[255,255,255,0,0.5]);
                                  var documento_numero=self.$content.find('input[name=documento_numero]').val();
                                  var documento_tipo_id=self.$content.find('select[name=documento_tipo]').val();
                                  $.post("personas/busqueda_por_documento",{"documento_numero":documento_numero,"documento_tipo_id":documento_tipo_id}
                                  ).done(function(data){
                                     
                                      var r=JSON.parse(data);
                                      if(!r.success){

                                        self.$content.find('input[name=nombres]').focus();
                                        self.$content.find('input[name=nombres]').val("");
                                        self.$content.find('input[name=apellidos]').val("");
                                        self.$content.find('select[name=postal]').find('option').each(function(){
                                          $(this).removeAttr('selected');
                                           if($(this).val()==51){
                                            $(this).attr('selected','selected');
                                           }
                                        });

                                        self.$content.find('input[name=celular]').val("");
                                        self.$content.find('input[name=correo_electronico]').val("");
                                        self.$content.find('input[name=nombres]').removeAttr('readonly');
                                        self.$content.find('input[name=apellidos]').removeAttr('readonly');
                                        
                                        hide_loadingOverlay(bt);
                                        return;
                                      }

                                      self.$content.find('input[name=nombres]').val(r.nombres);
                                      self.$content.find('input[name=apellidos]').val(r.apellidos);
                                      self.$content.find('input[name=celular]').val(r.celular_numero);
                                      self.$content.find('input[name=correo_electronico]').val(r.correo_electronico);
                                      if(r.return=="from_dni"){
                                        self.$content.find('input[name=nombres]').attr('readonly',true);
                                        self.$content.find('input[name=apellidos]').attr('readonly',true);
                                        self.$content.find('input[name=celular]').focus();
                                      }else{
                                        self.$content.find('input[name=nombres]').removeAttr('readonly');
                                        self.$content.find('input[name=apellidos]').removeAttr('readonly');
                                      } 
                                      self.$content.find('select[name=postal]').find('option').each(function(){
                                        $(this).removeAttr('selected');
                                          if($(this).val()==parseInt(r.celular_numero_postal_id)){
                                            
                                            $(this).attr('selected','selected');
                                          }
                                      });
                                      hide_loadingOverlay(bt);
                                  });
                              });
                              
                              this.$content.find('a[role=finalizar]').click(function(){ 
                                      var bt=this;
                                      var form=self.$content.find('form');
                                      $(bt).html("cerrando pedido...");
                                      show_loadingOverlay(bt,[255,255,255,0,0.5]);
                                                                
                                      $.post('pedidos/guardar_cerrar_pedido',$(form).serializeArray()
                                        ).done(function(data){
                                         
                                          var r=JSON.parse(data);
                                          if(r.success){
                                            alert(r.msg);
                                            window.open("pedidos/print_ticket?p_id="+$(form).find('input[name=pedido_id]').val(),"_blank");
                                            location.reload();
                                            return;
                                          }
                                          switch(r.msg_id){
                                            case 1:
                                              self.$content.find('p[role=caja_aperturada_error]').removeClass('d-none');
                                              self.$content.find('p[role=caja_aperturada_error]').html(r.msg);
                                              break;
                                            default:
                                              alert(r.msg);
                                              break;
                                          }
                                          hide_loadingOverlay(bt);
                                          return;
                                        });    
                              });
                              this.$content.find('a[role=cancel]').click(function(){
                                  self.close();
                              });
                          }
                      });
                    });
                    
                    this.$content.find('a[role=agregar_articulo]').click(function(){ 
                      $.dialog({
                            closeIcon: true,
                            type: 'danger',
                            boxWidth: '60%',
                            useBootstrap: false,
                            scrollToPreviousElement: true,
                            content:function(){
                                var self=this;
                                formulario_buscar_articulo=self;
                                return $.post("pedidos/abrir_agregar_nuevo")
                                .done(function(data){
                                    var r=JSON.parse(data);
                                    self.setTitle(r.title);
                                    self.setContentAppend(r.template);
                                });
                            },
                            onContentReady:function(){
                                var self=this;
                                self.$content.find('a[role=agregar_a_detalle]').on('click',function(event){
                                    alert("hola");
                                });
                                self.$content.find('input[name=filtro]').on("keyup",function(event){ 
                                   event.preventDefault();
                                   var input=$(this);
                                   var c_id=self.$content.find('select[name=busqueda_por]').val();
                                   if($(input).val().length>=3){
                                  
                                     $.post('pedidos/buscar_articulo',{"busqueda_por":c_id,"filtro":$(input).val()}
                                      ).done(function(data){
                                          
                                          var r=JSON.parse(data);
                                          var tabla=self.$content.find('table');
                                          $(tabla).find('tbody').html("");
                                          var trs="";
                                          
                                          for(var i=0;i<r.length;i++){
                                            trs+='<tr>';
                                            trs+='<td>'+r[i].denominacion+'</td>';
                                            var precio=parseFloat(r[i].precio_pen);
                                            trs+='<td>S/.'+precio.toFixed(2)+'</td>';
                                            trs+='<td><a onclick="enviarADetalle(this,event)" class="btn btn-light" data-articulo-id="'+r[i].id+'" data-articulo-denominacion="'+r[i].denominacion+'" data-articulo-precio="'+r[i].precio_pen+'"><i class="fas fa-file-import"></i>&nbsp;Enviar al detalle</a></td>';
                                            trs+='</tr>';
                                          }
                                          $(tabla).find('tbody').html(trs);
                                      });
                                   }else{
                                      //alert("hola");
                                      var tabla=self.$content.find('table');
                                      $(tabla).find('tbody').html("");
                                      var trs="";
                                      for(var i=0;i<5;i++){
                                        trs+='<tr>';
                                            trs+='<td></td>';
                                            trs+='<td></td>';
                                            trs+='<td></td>';
                                            trs+='</tr>';
                                      }
                                      $(tabla).find('tbody').html(trs);
                                   }
                                }); 

                            }
                        });           
                    });
                           
                }
            });
        }
        
        function enviarADetalle(bt,event){
          event.preventDefault();
          formulario_detalle_mesa.$content.find('tbody').find('tr').each(function(index){
                if($(this).find('td:eq(1)').html()==""){
                    $(this).remove();
                }
          });
          var esta_agregado=false;
          formulario_detalle_mesa.$content.find('tbody').find('tr').each(function(index){
                if($(this).find('td:eq(1)').attr('data-articulo-id')==$(bt).attr('data-articulo-id')){
                  alert("El producto ya se encuentra agregado al detalle");  
                  esta_agregado=true;
                    
                }
          });
          if(!esta_agregado){
            var new_index=formulario_detalle_mesa.$content.find('tbody').children().length;
            var tr='<tr>';
            var precio=parseFloat($(bt).attr('data-articulo-precio'));
            tr+= '<td class="text-center">'+
                      '<div class="input-group mb-3">'+
                      ' <div class="input-group-prepend">'+
                      '      <button data-index="'+new_index+'" class="btn btn-dark" onclick="agregarQuitarCantidad(this,event)" type="button">+</button>'+
                      '  </div>'+
                      '  <input type="text" name="detalle['+new_index+'][cantidad]" class="form-control text-center" readonly value="1" aria-label="" aria-describedby="basic-addon1">'+
                      '  <div class="input-group-append">'+
                      '      <button data-index="'+new_index+'" class="btn btn-dark" onclick="agregarQuitarCantidad(this,event)" type="button">-</button>'+
                      '  </div>'+                                  
                    '</div>'+
                  '</td>';
            tr+= '<td class="text-left" data-articulo-id="'+$(bt).attr('data-articulo-id')+'"><input type="hidden" readonly name="detalle['+new_index+'][articulo_id]" value="'+$(bt).attr('data-articulo-id')+'" />'+$(bt).attr('data-articulo-denominacion')+'</td>';
            tr+= '<td class="text-center"><input type="hidden" readonly name="detalle['+new_index+'][precio]" value="'+precio+'" />'+precio.toFixed(2)+'</td>';
            tr+= '<td class="text-center">'+precio.toFixed(2)+'</td>';
            tr+= '<td class="text-center">';
            tr+= '  <input type="hidden" readonly class="form-control" name="detalle['+new_index+'][descripcion]" />';
            tr+= '  <a class="btn btn-light" data-index="'+new_index+'" role="agregar_descripcion" href="pedidos/agrega_descripcion" onclick="agregaDescripcion(this,event)"><i class="fas fa-folder-plus"></i></a>';
            tr+= '  <a class="btn btn-light" data-index="'+new_index+'"><i class="fas fa-trash-alt"></i></a>';
            tr+= '</td>';
            tr+= '</tr>';
            formulario_detalle_mesa.$content.find('tbody').append(tr);
            formulario_detalle_mesa.$content.find('a[role="guardar"]').removeClass('disabled');
          }
          var total=0;
          formulario_detalle_mesa.$content.find('tbody').find('tr').each(function(index){
                total+=parseFloat($(this).find('td:eq(3)').html());
          });
          formulario_detalle_mesa.$content.find('label[role=total]').html('S/. '+total.toFixed(2));
          formulario_buscar_articulo.close();
        }
        function agregaDescripcion(bt,event){
            event.preventDefault();
            var inputDescripcion=$(bt).parent().find('input');
            var index=$(bt).attr('data-index');
            var tr=formulario_detalle_mesa.$content.find('tbody').find('tr:eq('+index+')');
            formulario_detalle_mesa.$content.find('a[role="guardar"]').removeClass('disabled');
            $.confirm({
                title: 'Añadir sugerencia de cliente:',
                content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Descripcion</label>' +
                '<input type="text" placeholder="ingrese sugerencia" class="sugerencia form-control" required value="'+$(inputDescripcion).val()+'"/>' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Aceptar',
                        btnClass: 'btn-blue',
                        action: function () {
                            var sugerencia = this.$content.find('.sugerencia').val();
                            // if(!sugerencia){
                            //     return false;
                            // }
                            $(inputDescripcion).val(sugerencia);
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        }
        function agregarQuitarCantidad(bt,event){
            event.preventDefault();
            var inputCantidad=$(bt).parent().parent().find('input');
            var index=$(bt).attr('data-index');
            var tr=formulario_detalle_mesa.$content.find('tbody').find('tr:eq('+index+')');
            
            if($(bt).html()=="+"){
                var cantidad=parseInt($(inputCantidad).val())+1;
                $(inputCantidad).val(cantidad);
                var precioUnit=parseFloat($(tr).find('td:eq(2)').find('input').val());
                var importe=parseFloat(cantidad*precioUnit);
                $(tr).find('td:eq(3)').html(importe.toFixed(2));

                var total=0;
                formulario_detalle_mesa.$content.find('tbody').find('tr').each(function(index){
                    total+=parseFloat($(this).find('td:eq(3)').html());
                });
                formulario_detalle_mesa.$content.find('label[role=total]').html('S/. '+total.toFixed(2));
                formulario_detalle_mesa.$content.find('a[role="guardar"]').removeClass('disabled');
            }else{
                var cantidad=parseInt($(inputCantidad).val())-1;
                if(cantidad>0){
                    $(inputCantidad).val(cantidad);
                    var precioUnit=parseFloat($(tr).find('td:eq(2)').find('input').val());
                    var importe=parseFloat(cantidad*precioUnit);
                    $(tr).find('td:eq(3)').html(importe.toFixed(2));

                    var total=0;
                    formulario_detalle_mesa.$content.find('tbody').find('tr').each(function(index){
                        total+=parseFloat($(this).find('td:eq(3)').html());
                    });
                    formulario_detalle_mesa.$content.find('label[role=total]').html('S/. '+total.toFixed(2));
                    formulario_detalle_mesa.$content.find('a[role="guardar"]').removeClass('disabled');
                }
            }
            
            
        }
        function agregarQuitarCantidad2(bt,event){
          
            event.preventDefault();
          
            var inputCantidadAPagar=$(bt).parent().parent().find('input[role="cantidad_a_pagar"]');
            var inputCantidadEnMesa=$(bt).parent().parent().find('input[role="cantidad_en_mesa"]');
          
            var index=$(bt).attr('data-index');
            var max=$(bt).attr('data-max');
            var tr=formulario_dividir_pedido.$content.find('tbody').find('tr:eq('+index+')');
           
            if($(bt).html()=="+"){
              var cantidadAPagar=parseInt($(inputCantidadAPagar).val())+1;
               if(max>=cantidadAPagar){
                  
                  $(inputCantidadAPagar).val(cantidadAPagar);
                  $(inputCantidadEnMesa).val(parseInt($(inputCantidadEnMesa).val())-1);
                  var precioUnit=parseFloat($(tr).find('td:eq(2)').find('input').val());
                  
                  var importe=parseFloat(cantidadAPagar*precioUnit);
                  $(tr).find('td:eq(3)').html(importe.toFixed(2));

                  var total=0;
                  formulario_dividir_pedido.$content.find('tbody').find('tr').each(function(index){
                      total+=parseFloat($(this).find('td:eq(3)').html());
                  });
                  var arrayTitle=formulario_dividir_pedido.title.split(' | ');
                  var monto=formulario_dividir_pedido.$content.find('input[name=monto]').val();
                  formulario_dividir_pedido.setTitle(arrayTitle[0]+' | Total pendiente: S/.'+(monto-total).toFixed(2));  
                  formulario_dividir_pedido.$content.find('label[role=total_a_pagar]').html('S/. '+total.toFixed(2));
                  formulario_dividir_pedido.$content.find('a[role="guardar"]').removeClass('disabled');

               }
                
            }else{
                var cantidadAPagar=parseInt($(inputCantidadAPagar).val())-1;
                if(cantidadAPagar>=0){
                    $(inputCantidadAPagar).val(cantidadAPagar);
                    $(inputCantidadEnMesa).val(parseInt($(inputCantidadEnMesa).val())+1);
                    var precioUnit=parseFloat($(tr).find('td:eq(2)').find('input').val());
                    var importe=parseFloat(cantidadAPagar*precioUnit);
                    $(tr).find('td:eq(3)').html(importe.toFixed(2));

                    var total=0;
                    formulario_dividir_pedido.$content.find('tbody').find('tr').each(function(index){
                        total+=parseFloat($(this).find('td:eq(3)').html());
                    });
                    var arrayTitle=formulario_dividir_pedido.title.split(' | ');
                    var monto=formulario_dividir_pedido.$content.find('input[name=monto]').val();
                    formulario_dividir_pedido.setTitle(arrayTitle[0]+' | Total pendiente: S/.'+(monto-total).toFixed(2));
                    formulario_dividir_pedido.$content.find('label[role=total_a_pagar]').html('S/. '+total.toFixed(2));
                    formulario_dividir_pedido.$content.find('a[role="guardar"]').removeClass('disabled');
                }
            }
            
            
        }
    </script>