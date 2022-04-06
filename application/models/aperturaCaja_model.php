<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AperturaCaja_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->distinct();
            $this->db->select('apertura_caja.id as id,apertura_caja.fecha_inicio as fecha_inicio,apertura_caja.fecha_cierre,cajas.id as caja_id,cajas.denominacion as caja_denominacion,personas.id as persona_id,personas.nombres as persona_nombres,personas.apellidos as persona_apellidos,roles.id as rol_id,roles.denominacion as rol_denominacion');
            $this->db->from('apertura_caja');
            $this->db->join('cajas','apertura_caja.caja_id=cajas.id');
            $this->db->join('usuarios','apertura_caja.usuario_id=usuarios.id');
            $this->db->join('roles','roles.id=usuarios.rol_id');
            $this->db->join('personas','personas.id=usuarios.persona_id');
            if(isset($filtros["id"])){
                $this->db->where('apertura_caja.id=',$filtros["id"]);   
            }
            if(isset($filtros["estado"])){
                if($filtros["estado"]=="abierta"){
                    $this->db->where('apertura_caja.fecha_cierre=','0000-00-00 00:00:00'); 
                }
                if($filtros["estado"]=="cerrada"){
                    $this->db->where('apertura_caja.fecha_cierre!=','0000-00-00 00:00:00'); 
                }    
            }

            if(isset($filtros["caja_id"])){
                $this->db->where('cajas.id=',$filtros["caja_id"]);
            }

            if(isset($filtros["establecimiento_id"])){
                $this->db->where('usuarios.establecimiento_id=',$filtros["establecimiento_id"]);
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
                "msg"=>"registros no encontrados",
            ); 
           
        }
       
    }
    
    public function insert($caja_id,$usuario_id){
        
        $this->db->set('fecha_inicio', DATE::getNowAccordingUTC());
        $this->db->set('caja_id', $caja_id);
        $this->db->set('usuario_id',$usuario_id);
        $this->db->insert('apertura_caja');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }

    public function cierre($id){
        $this->db->set('fecha_cierre', DATE::getNowAccordingUTC());
        $this->db->where('id=',$id);
        $this->db->update('apertura_caja');
        return array("success"=>true,"msg"=>"cierre existoso");   
    }
}