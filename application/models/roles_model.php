<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('establecimientosTipos_model');
    }
    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            
            $this->db->distinct();
            $this->db->select('*');
            $this->db->from('roles');

            if(isset($filtros["id"])){
                $this->db->where('roles.id=',$filtros["id"]);   
            }
            if(isset($filtros["num_filas"]) && isset($filtros["pagina"]) && isset($filtros["fila_inicial"])){
                $this->db->limit($filtros["num_filas"],$filtros["fila_inicial"]-1);
            }
            $query = $this->db->get(); 

            if($query->num_rows()>=0){
                $result=$query->result_array();
                return array(
                    "success"=>true,
                    "data"=>$result
                );
            } 
            return array(
                "success"=>false,
                "msg"=>"roles no encontradas",
            ); 
        }
    }
    
}