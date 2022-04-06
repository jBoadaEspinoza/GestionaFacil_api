<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Establecimientos_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->distinct();
            $this->db->select('establecimientos_tipos_grupos.id as establecimiento_tipo_id,establecimientos_tipos_grupos.denominacion_es as establecimiento_tipo_denominacion_es,establecimientos_tipos_grupos.denominacion_en as establecimiento_tipo_denominacion_en');
            $this->db->from('establecimientos_registra_establecimientos_tipos');
            $this->db->join('establecimientos_tipos', 'establecimientos_registra_establecimientos_tipos.establecimiento_tipo_id = establecimientos_tipos.id');
            $this->db->join('establecimientos_tipos_grupos', 'establecimientos_tipos.grupo_id = establecimientos_tipos_grupos.id');
            $this->db->join('establecimientos', 'establecimientos_registra_establecimientos_tipos.establecimiento_id = establecimientos.id');
            
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('establecimientos.id=',$filtros["establecimiento_id"]);   
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
                "msg"=>"Tipo de establecimiento no encontrada",
            ); 
           
        }
        
        return array(
            "success"=>false,
            "msg"=>"Tipo de establecimiento no encontrado",
        ); 

    }
    public function abrir_cerrar($abierto,$id){
        $this->db->set('abierto', $abierto);
        $this->db->where('id=',$id);
        $this->db->update('establecimientos');
        return array("success"=>true,"msg"=>"registro actualizado");  
    }
}