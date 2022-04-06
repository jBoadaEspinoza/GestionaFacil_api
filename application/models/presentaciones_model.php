<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presentaciones_model extends CI_Model
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
            $this->db->from('presentaciones');
            
            if(isset($filtros["id"])){
                $this->db->where('presentaciones.id=',$filtros["id"]);   
            }
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('presentaciones.establecimiento_id=',$filtros["establecimiento_id"]);
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
    
    public function actualizar($id,$denominacion,$establecimiento_id){
        $this->db->set('denominacion', $denominacion);
        $this->db->set('establecimiento_id', $establecimiento_id);
        $this->db->where('id=',$id);
        $this->db->update('presentaciones');
        return array("success"=>true,"msg"=>"Registro actualizado correctamente");       
    }

    public function insert($denominacion,$establecimiento_id){
        
        $this->db->set('denominacion', $denominacion);
        $this->db->set('establecimiento_id', $establecimiento_id);
        $this->db->insert('presentaciones');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }
    public function delete($id){
        $this->db->where('id=',$id);
        $this->db->delete('presentaciones');

        $this->db->select('*');
        $this->db->from('presentaciones');
        $this->db->where('id=',$id);
    

        $query = $this->db->get(); 
        if($query->num_rows()>=0){
            
            return array(
                "success"=>false,
                "msg"=>"Error al eliminar el registro ".md5($id)
            );
        } 
        return array(
            "success"=>true,
            "msg"=>"Registro eliminado con exito",
        ); 
       
    }
}