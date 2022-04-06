<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Mesas extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mesas_model');
        $this->load->model('pedidos_model');
        // $this->load->model('Api/auth_model');
    }
    public function index_get($id = null){
        
        $establecimiento_id=$this->input->get('e_id');
        $filtros=array("establecimiento_id"=>$establecimiento_id);
        $objMesas=$this->mesas_model->get($filtros);
        
        $mesas=$objMesas["data"];
        foreach($mesas as $index=>$mesa){
            $objPedidos=$this->pedidos_model->get(array("establecimiento_id"=>$establecimiento_id,"cerrado"=>0));
            $pedidos=$objPedidos["data"];
            $mesas[$index]["estado"]="disponible";
            $mesas[$index]["referencia_pedido"]=0;
            //$mesas[$index]["url"]=base_url()."assets/img/mesa_desocupado.png";
            if($mesa["id"]==20){
                $mesas[$index]["url"]=base_url()."assets/img/cash-paymen_desocupado.png";
            }else{
                $mesas[$index]["url"]=base_url()."assets/img/mesa_desocupado.png";
            }
            foreach($pedidos as $index_pedidos=>$pedido){
                if($pedido["referencia_a_bd"]!=""){
                    $referencia_array = array();
                    parse_str($pedido["referencia_a_bd"], $referencia_array);
                    if($referencia_array["mesa_id"]==$mesa["id"]){
                        if($mesa["id"]==20){
                            $mesas[$index]["url"]=base_url()."assets/img/cash-paymen_ocupado.png";
                        }else{
                            $mesas[$index]["url"]=base_url()."assets/img/mesa_ocupado.png";
                        }
                        
                        $mesas[$index]["estado"]="ocupado";
                        $mesas[$index]["referencia_pedido"]=$pedido["id"];
                        break;
                    }
                }
            }
        }
        
        if (!$objMesas["success"]){
            //indicara que establecimiento no existe
        }

        $output["response"]["success"]=true;
        $output["response"]["data"]=$mesas;
        $this->set_response($output,200);
            
    }
}