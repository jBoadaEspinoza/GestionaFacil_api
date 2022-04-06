<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Articulos extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('articulos_model');
        $this->load->model('pedidos_model');
        $this->load->model('pedidosDetalles_model');
        // $this->load->model('Api/auth_model');
    }
    public function index_get($id = null){
        

        if(isset($_GET["buscar_por"])){
            switch ($this->get('buscar_por')){
                case "denominacion":
                    $filtro=array(
                        "articulo_denominacion"=>strtolower($this->get('v')),
                        "establecimiento_id"=>$this->get('e_id'),
                        "fila_inicial"=>$this->get('fila_inicial'),
                        "num_filas"=>$this->get('num_filas')
                    );
                    $objArticulos=$this->articulos_model->get($filtro);
        
                    $output["response"]["success"]=true;
                    $output["response"]["data"]=$objArticulos["data"];
                    $this->set_response($output,200);
                    return;
                    break;
            }
        }

        if(isset($_GET["e_id"]) && isset($_GET["fila_inicial"]) && isset($_GET["num_filas"])){
          
            $filtro=array(
                "establecimiento_id"=>$this->get('e_id'),
                "fila_inicial"=>$this->get('fila_inicial'),
                "num_filas"=>$this->get('num_filas')
            );
            $objArticulos=$this->articulos_model->get($filtro);

            $output["response"]["success"]=true;
            $output["response"]["data"]=$objArticulos["data"];
            $this->set_response($output,200);
            return;
        }
        
    }
}