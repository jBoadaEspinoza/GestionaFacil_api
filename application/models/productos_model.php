<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->distinct();
            $this->db->select('*');
            $this->db->from('productos');
            
            if(isset($filtros["id"])){
                $this->db->where('productos.id=',$filtros["id"]);   
            }
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('productos.establecimiento_id=',$filtros["establecimiento_id"]);
            }
            if(isset($filtros["num_filas"]) && isset($filtros["pagina"]) && isset($filtros["fila_inicial"])){
                $this->db->limit($filtros["num_filas"],$filtros["fila_inicial"]-1);
            }
            //$this->db->order_by('fecha_de_registro', 'DESC');
            //$this->db->order_by('ultima_actualizacion', 'DESC');
            
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
                "msg"=>"articulos no encontradas",
            ); 
           
        }
       
        return array(
            "success"=>false,
            "msg"=>"Usuario no encontrado",
        ); 

    }
    
    
}