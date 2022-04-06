<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Usuarios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        // $this->load->model('Api/auth_model');
    }
    
    public function index_get($id = null){
        if(!is_null($id)){
            $objUsuario=$this->usuarios_model->get(array("id"=>$id));
            if(!$objUsuario["success"]){
                $output["response"]["success"]=false;
                $output["response"]["message"]=$objUsuario["msg"];
                $this->set_response($output,403);
                return;
            }
            $output["response"]["success"]=true;
            $output["response"]["data"]=$objUsuario["data"][0];
            $this->set_response($output,200);
            return;
        }
    }
    public function index_post(){
        if(is_null(AUTHORIZATION::getContentTypeHeader())){
            //ERROR N°-1
            $output["response"]["message"]="Error 422: Expected Content-Type: application/json.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }

        $ruc=$this->post('ruc');
        $nombre=$this->post('nombre');
        $clave=$this->post('clave');
        $rol_id=$this->post('rol_id');
        
        $objUsuario=$this->usuarios_model->validate($ruc,$nombre,$clave,$rol_id);

        $output["response"]=$objUsuario;
        
        $this->set_response($output,200);
        return;
    }
}
