<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Pedidos extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mesas_model');
        $this->load->model('pedidos_model');
        $this->load->model('pedidosDetalles_model');
        $this->load->model('aperturaCaja_model');
        $this->load->model('aperturaCajaItems_model');
        $this->load->model('personas_model');
        $this->load->model('documentosTipos_model');
        $this->load->model('paises_model');
        // $this->load->model('Api/auth_model');
    }
    public function index_get($id = null){
    
        if(!is_null($id)){

            if(isset($_GET["operacion"])){
                switch ($this->get('operacion')){
                    
                    case "delete":
                        $delete=$this->pedidos_model->delete($id);
                        $output["response"]["success"]=true;
                        $output["response"]["msg"]=$delete["msg"];
                        $this->set_response($output,200);
                        return;
                        break;

                    case "delete_item":
                        $delete=$this->pedidosDetalles_model->delete($id,$this->get("a_id"));
                        $output["response"]["success"]=true;
                        $output["response"]["msg"]=$delete["msg"];
                        $this->set_response($output,200);
                        return;
                        break;

                    case "cierre_de_pedido_parametros":
                        $data=array("modalidades_de_pago"=>APIS::getModalidadesDePago());
                        $output["response"]["success"]=true;
                        $output["response"]["data"]=$data;
                        $this->set_response($output,200);
                        return;
                        break;
                }
                
            }

            $filtro=array("pedido_id"=>$id);
            $objPedidosDetalles=$this->pedidosDetalles_model->get($filtro);

            $output["response"]["success"]=true;
            $output["response"]["data"]["detalle"]=$objPedidosDetalles["data"];
            $this->set_response($output,200);
            return;
        }
        if(isset($_GET["operacion"])){
            switch ($this->get('operacion')){
                case "cierre_de_pedido_parametros":
                    if(isset($_GET["e_id"])){
                        $establecimiento_id=$this->get("e_id");
                        $objAperturaCaja=$this->aperturaCaja_model->get(array("establecimiento_id"=>$establecimiento_id,"estado"=>"abierta"));
                        $cajas_aperturadas=$objAperturaCaja["data"];
                        $modalidades_de_pagos=APIS::getModalidadesDePago();
                        $objDocumentosTipos=$this->documentosTipos_model->get(array());
                        $documentos_tipos=$objDocumentosTipos["data"];
                        $objPaises=$this->paises_model->get(array());
                        $paises=$objPaises["data"];
                        $data=array(
                            "cajas_aperturadas"=>$cajas_aperturadas,
                            "modalidades_de_pago"=>$modalidades_de_pagos,
                            "documentos_tipos"=>$documentos_tipos,
                            "paises"=>$paises
                        );
                        $output["response"]["success"]=true;
                        $output["response"]["data"]=$data;
                        $this->set_response($output,200);
                        return;
                    }
                    break;
            }
        }
    }
    public function cierre_post($id){
        if(is_null(AUTHORIZATION::getContentTypeHeader())){
            //ERROR N°-1
            $output["response"]["message"]="Error 422: Expected Content-Type: application/json.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }
        $pedido_id=$id;
        $mesa_id=$this->post("mesa_id");
        $moneda_id=$this->post("moneda_id");
        $monto=$this->post("monto");
        $apertura_caja_id=$this->post("caja_aperturada");
        $documento_tipo_id=$this->post("documento_tipo");
        $documento_numero=$this->post("documento_numero");
        $nombres=$this->post("nombres");
        $apellidos=$this->post("apellidos");
        $celular_postal=$this->post("postal");
        $celular_numero=$this->post("celular");
        $correo_electronico=$this->post("correo_electronico");
        $modalidad_pago_id=$this->post("modalidad_pago");

        self::cerrar_pedido($pedido_id,$mesa_id,$moneda_id,$monto,$apertura_caja_id,$documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_postal,$celular_numero,$correo_electronico,$modalidad_pago_id);
        return;
    }
    public function index_post(){
        if(is_null(AUTHORIZATION::getContentTypeHeader())){
            //ERROR N°-1
            $output["response"]["message"]="Error 422: Expected Content-Type: application/json.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }

        $mozo_id=$this->post('mozo_id');
        $pedido_id=$this->post('pedido_id');
        $detalles=json_decode($this->post('detalle'),true);
        $mesa_denominacion=$this->post('mesa_denominacion');
        $mesa_id=$this->post('mesa_id');
        $cliente_id=$this->post('cliente_id');
           
        if($pedido_id==0){
            $cliente_id=0;
            $referencia_a_bd="venta=establecimiento&modo=presencial&mesa_id=".$mesa_id;
            $pedido_guardado=$this->pedidos_model->insert($referencia_a_bd,$mozo_id,$cliente_id);
            if(!$pedido_guardado["success"]){

            }
            $pedido_id=$pedido_guardado["id"];
            foreach($detalles as $index=>$dt){
                $cantidad=$dt["cantidad"];
                $precio=$dt["precio_unitario"];
                $articulo_id=$dt["articulo_id"];
                $sugerencia=$dt["sugerencia"];
                $pedido_detalle_guardado=$this->pedidosDetalles_model->insert($pedido_id,$articulo_id,$precio,$cantidad,$sugerencia);
            }

            $output["response"]["success"]=true;
            $output["response"]["operacion"]="inserted";
            $output["response"]["msg"]="registro guardado con exito";
            $output["response"]["data"]=array(
                "id"=>$pedido_id,
                "mesa_denominacion"=>$mesa_denominacion
            );
            $this->set_response($output,200);
            return;

        }else{
            foreach($detalles as $index=>$dt){
                $cantidad=$dt["cantidad"];
                $precio=$dt["precio_unitario"];
                $articulo_id=$dt["articulo_id"];
                $sugerencia=$dt["sugerencia"];
                $objPedidosDetalles=$this->pedidosDetalles_model->get(array("pedido_id"=>$pedido_id,"articulo_id"=>$articulo_id));
            
                if(count($objPedidosDetalles["data"])>0){
                    $pedido_detalle=$objPedidosDetalles["data"][0];
                    //if($pedido_detalle["cantidad"]!=$cantidad){
                        $actualizado=$this->pedidosDetalles_model->actualizar($pedido_id,$articulo_id,$precio,$cantidad,$sugerencia);
                    //}
                }else{
                    $pedido_detalle_guardado=$this->pedidosDetalles_model->insert($pedido_id,$articulo_id,$precio,$cantidad,$sugerencia);
                }
            }
        
            $output["response"]["success"]=true;
            $output["response"]["operacion"]="updated";
            $output["response"]["msg"]="registro actualizado con exito";
            $output["response"]["data"]=array(
                "id"=>$pedido_id,
                "mesa_denominacion"=>$mesa_denominacion
            );
            $this->set_response($output,200);
            return;
        }
    }

    private function cerrar_pedido($pedido_id,$mesa_id,$moneda_id,$monto,$apertura_caja_id,$documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_postal,$celular_numero,$correo_electronico,$modalidad_pago_id){
        
        if(is_null($apertura_caja_id)  || $apertura_caja_id==0){
            $output["response"]["success"]=false;
            $output["response"]["msg_id"]=1;
            $output["response"]["msg"]="no hay caja aperturada";
            $this->set_response($output,200);
            return;
        }

        $referencia="tipo=entrada&pedido_id=".$pedido_id."&mesa_id=".$mesa_id."&modalidad_pago=".APIS::getModalidadDePago($modalidad_pago_id)["denominacion"];
        $item_descripcion="V. directa";
        $aperturaCajaItems=$this->aperturaCajaItems_model->insert($apertura_caja_id,$item_descripcion,$moneda_id,$monto,$referencia);
        
        if(!$aperturaCajaItems["success"]){
            $output["response"]["success"]=false;
            $output["response"]["msg_id"]=2;
            $output["response"]["msg"]="error al registrar en caja";
            $this->set_response($output,200);
            return;
        }

        $cliente_id=0;
        if($documento_numero!=""){
            $objPersonas=$this->personas_model->get(array("documento_tipo_id"=>$documento_tipo_id,"documento_numero"=>$documento_numero));
            if(count($objPersonas["data"])==0){
            //registramos a la persona en la base de datos
            $persona_registrada=$this->personas_model->insert($documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_numero,$celular_postal,$correo_electronico);
            if(!$persona_registrada["success"]){
                $output["response"]["success"]=false;
                $output["response"]["msg_id"]=3;
                $output["response"]["msg"]="error al registrar el cliente";
                $this->set_response($output,200);
                return;
                    
            }
            $cliente_id=$persona_registrada["id"];
            }else{
                $cliente_id=$objPersonas["data"][0]["id"]; 
                $actualizado=$this->personas_model->actualizar($cliente_id,$documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_numero,$celular_postal,$correo_electronico);
            }
        }
        
        $cerrado=1;
        $objPedidos=$this->pedidos_model->get(array("id"=>$pedido_id));
        if(!$objPedidos["success"]){
            $output["response"]["success"]=false;
            $output["response"]["msg_id"]=4;
            $output["response"]["msg"]="error al listar el pedido";
            $this->set_response($output,200);
            return;
            
        }

        $pedido=$objPedidos["data"][0];
        $referencia_a_bd=$pedido["referencia_a_bd"];
        $pedido_actualizado=$this->pedidos_model->actualizar($pedido_id,$referencia_a_bd,$cliente_id,$cerrado);

        if(!$pedido_actualizado["success"]){
            $output["response"]["success"]=false;
            $output["response"]["msg_id"]=5;
            $output["response"]["msg"]="error al actualizar el pedido";
            $this->set_response($output,200);
            return;
            
        }
        $output["response"]["success"]=true;
        $output["response"]["msg"]="registro guardado correctamente";
        $this->set_response($output,200);
    }
}

