<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Personas extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('personas_model');
        // $this->load->model('Api/auth_model');
    }
    public function index_get($id = null){
        if(is_null($id)){

        }
        if(isset($_GET["documento_tipo_id"]) && isset($_GET["documento_numero"])){
            $documento_tipo_id=$this->get('documento_tipo_id');
            $documento_numero=$this->get('documento_numero');
            $filtros=array("documento_tipo_id"=>$documento_tipo_id,"documento_numero"=>$documento_numero);
            $objPersonas=$this->personas_model->get($filtros);
            
            
            if(count($objPersonas["data"])==0 ){
                if($documento_tipo_id==1){
                    $dni=$documento_numero;
                    $data=APIS::getDNI($dni);
                    
                    if(!$data["success"]){
                        //echo json_encode(array("success"=>false,"msg_id"=>2,"msg"=>$data["msg"]));
                        $output["response"]["success"]=false;
                        $output["response"]["msg_id"]=2;
                        $output["response"]["msg"]=$data["msg"];
                        $this->set_response($output,200);
                        return;
                    }
                   
                    $output["response"]["success"]=true;
                    $output["response"]["return"]="from_dni";
                    $output["response"]["data"]=array(
                        "nombres"=>strtoupper($data["nombres"]),
                        "apellidos"=>strtoupper($data["apellidoPaterno"].' '.$data["apellidoMaterno"]),
                        "celular_postal"=>"51",
                        "celular_numero"=>"",
                        "correo_electronico"=>""
                    );
                    $this->set_response($output,200);
                    return;
                }
                if($documento_tipo_id==2){
                    $ruc=$documento_numero;
                    $data=APIS::getRUC($ruc);
                    
                    if(!$data["success"]){
                        $output["response"]["success"]=false;
                        $output["response"]["msg_id"]=2;
                        $output["response"]["msg"]=$data["msg"];
                        $this->set_response($output,200);
                        return;
                    }
                    $output["response"]["success"]=true;
                    $output["response"]["return"]="from_ruc";
                    $output["response"]["data"]=array(
                        "razon_social"=>$data["razonSocial"],
                        "direccion"=>$data["direccion"],
                        "estado"=>$data["estado"],
                        "condicion"=>$data["condicion"],
                        "celular_postal"=>"51",
                        "celular_numero"=>"",
                        "correo_electronico"=>""
                    );
                    $this->set_response($output,200);
                    return;
                   
                }
    
                //echo json_encode(array("success"=>false,"data"=>$documento_tipo_id,"msg_id"=>1,"msg"=>"no hay registro"));
                $output["response"]["success"]=false;
                $output["response"]["msg_id"]=1;
                $output["response"]["msg"]="no hay registro";
                $this->set_response($output,200);
                return;
            }
            $personas=$objPersonas["data"][0];
            if($personas["documento_tipo_id"]==2){
                $output["response"]["success"]=true;
                $output["response"]["return"]="from_bd";
                $output["response"]["data"]=array(
                    "razon_social"=>$personas["razon_social"],
                    "direccion"=>$personas["direccion"],
                    "celular_postal"=>$personas["celular_postal"]=="" ? "51" : $personas["celular_postal"] ,"celular_numero"=>$personas["celular_numero"],
                    "correo_electronico"=>$personas["correo_electronico"]
                );
                $this->set_response($output,200);
                return;
            }else{
                $output["response"]["success"]=true;
                $output["response"]["return"]="from_bd";
                $output["response"]["data"]=array(
                    "nombres"=>$personas["nombres"],
                    "apellidos"=>$personas["apellidos"],
                    "celular_postal"=>$personas["celular_postal"]=="" ? "51" : $personas["celular_postal"] ,"celular_numero"=>$personas["celular_numero"],
                    "correo_electronico"=>$personas["correo_electronico"]
                );
                $this->set_response($output,200);
                return;
            }
            


            
        }
        
            
    }
}