<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentosTipos_model extends CI_Model
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
            $this->db->from('documentos_tipos');

            if(isset($filtros["id"])){
                $this->db->where('documentos_tipos.id=',$filtros["id"]);   
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
                "msg"=>"documentos tipos no encontradas",
            ); 
           
        }
       
    }
    
    // public function actualizar($id,$denominacion_por_unidad,$denominacion_por_grupo,$descripcion,$imagen_url,$establecimiento_id){
    //     $this->db->set('denominacion_por_unidad', $denominacion_por_unidad);
    //     $this->db->set('denominacion_por_grupo', $denominacion_por_grupo);
    //     $this->db->set('descripcion', $descripcion);
    //     $this->db->set('imagen_url', $imagen_url);
    //     $this->db->set('establecimiento_id', $establecimiento_id);
    //     $this->db->set('ultima_actualizacion',DATE::getNowAccordingUTC());
    //     $this->db->where('id=',$id);
    //     $this->db->update('categorias');
    //     return array("success"=>false,"msg"=>"Error al actualizar el registro");       
    // }

    public function insert($denominacion,$establecimiento_id){
        
        $this->db->set('denominacion', $denominacion);
        $this->db->set('establecimiento_id', $establecimiento_id);
        $this->db->set('fecha_de_registro',DATE::getNowAccordingUTC());
        $this->db->insert('cajas');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }
    // public function delete($id){
    //     $this->db->where('id=',$id);
    //     $this->db->delete('categorias');

    //     $this->db->select('*');
    //     $this->db->from('categorias');
    //     $this->db->where('id=',$id);
    

    //     $query = $this->db->get(); 
    //     if($query->num_rows()>=0){
            
    //         return array(
    //             "success"=>false,
    //             "msg"=>"Error al eliminar el registro ".md5($id)
    //         );
    //     } 
    //     return array(
    //         "success"=>true,
    //         "msg"=>"Registro eliminado con exito",
    //     ); 
       
    // }
}