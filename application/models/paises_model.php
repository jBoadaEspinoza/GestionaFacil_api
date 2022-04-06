<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paises_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->select('*');
            $this->db->from('paises');
            
            if(isset($filtros["id"])){
                $this->db->where('paises.id=',$filtros["id"]);   
            }

            if(isset($filtros["alpha2Code"])){
                $this->db->where('paises.alpha2Code=',$filtros["alpha2Code"]);   
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
                "msg"=>"paises no encontradas",
            ); 
           
        }
       
        return array(
            "success"=>false,
            "msg"=>"paise no encontrado",
        ); 

    }
    
    
}