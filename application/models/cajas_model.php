<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cajas_model extends CI_Model
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
            $this->db->from('cajas');

            if(isset($filtros["id"])){
                $this->db->where('cajas.id=',$filtros["id"]);   
            }
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('cajas.establecimiento_id=',$filtros["establecimiento_id"]);
            }
            if(isset($filtros["num_filas"]) && isset($filtros["pagina"]) && isset($filtros["fila_inicial"])){
                $this->db->limit($filtros["num_filas"],$filtros["fila_inicial"]-1);
            }
            $this->db->order_by('fecha_de_registro', 'DESC');
            $this->db->order_by('ultima_actualizacion', 'DESC');
            $query = $this->db->get(); 



            if($query->num_rows()>=0){
                $result=$query->result_array();
                foreach($result as $index=>$r){    
                    $esta_aperturado=self::esta_aperturado($r["id"]);
                    $result[$index]["aperturado"]=($esta_aperturado["success"]) ? 1 : 0;
                }
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
    
    public function esta_aperturado($caja_id){
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('apertura_caja');
        $this->db->where('apertura_caja.caja_id=',$caja_id);
        $this->db->where('apertura_caja.fecha_cierre=','0000-00-00 00:00:00');   
        
        $query = $this->db->get(); 

        if($query->num_rows()>0){
            $result=$query->result_array();
            return array(
                "success"=>true
            );
        } 
        return array(
            "success"=>false
        ); 
           
        
    }
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
}