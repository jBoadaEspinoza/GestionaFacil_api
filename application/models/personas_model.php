<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personas_model extends CI_Model
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
            $this->db->from('personas');

            if(isset($filtros["id"])){
                $this->db->where('personas.id=',$filtros["id"]);   
            }
            if(isset($filtros["documento_tipo_id"])){
                $this->db->where('personas.documento_tipo_id=',$filtros["documento_tipo_id"]);
            }
            if(isset($filtros["documento_numero"])){
                $this->db->where('personas.documento_numero=',$filtros["documento_numero"]);
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
                "msg"=>"cajas no encontradas",
            ); 
           
        }
       
    }
    
    public function insert($documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_numero="",$celular_postal="51",$correo_electronico=""){
        
        $this->db->set('documento_tipo_id', $documento_tipo_id);
        $this->db->set('documento_numero', $documento_numero);
        if($documento_tipo_id==2){
            $this->db->set('razon_social', $nombres);
            $this->db->set('direccion', $apellidos);
        }else{
            $this->db->set('nombres', $nombres);
            $this->db->set('apellidos', $apellidos);
        }
        $this->db->set('celular_numero', $celular_numero);
        $this->db->set('celular_postal', $celular_postal);
        $this->db->set('correo_electronico', $correo_electronico);
     
        $this->db->insert('personas');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }
    public function actualizar($id,$documento_tipo_id,$documento_numero,$nombres,$apellidos,$celular_numero="",$celular_postal="51",$correo_electronico=""){
        
        $this->db->set('documento_tipo_id', $documento_tipo_id);
        $this->db->set('documento_numero', $documento_numero);
        if($documento_tipo_id==2){
            $this->db->set('razon_social', $nombres);
            $this->db->set('direccion', $apellidos);
        }else{
            $this->db->set('nombres', $nombres);
            $this->db->set('apellidos', $apellidos);
        }
        $this->db->set('celular_numero', $celular_numero);
        $this->db->set('celular_postal', $celular_postal);
        $this->db->set('correo_electronico', $correo_electronico);
        $this->db->where('id=',$id);
        $this->db->update('personas');

        return array("success"=>true,"msg"=>"Registro actualizado con exito");   

    }
}