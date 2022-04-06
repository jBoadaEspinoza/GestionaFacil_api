<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PermisosUsuarios_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->select('permisos.id as id,permisos.denominacion as denominacion,usuarios.id as usuario_id');
            $this->db->from('permisos_usuarios');
            $this->db->join('permisos','permisos_usuarios.permiso_id=permisos.id');
            $this->db->join('usuarios', 'permisos_usuarios.usuario_id = usuarios.id');
            

            if(isset($filtros["permiso_id"])){
                $this->db->where('permisos.id=',$filtros["permiso_id"]);   
            }
            if(isset($filtros["usuario_id"])){
                $this->db->where('usuarios.id=',$filtros["usuario_id"]);
               
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
                "msg"=>"registros no encontrads",
            ); 
           
        }
        
        return array(
            "success"=>false,
            "msg"=>"registro no encontrado",
        ); 

    }
    public function actualizar($pedido_id,$articulo_id,$precio_unitario_pen,$cantidad,$sugerencias){
        
        $this->db->set('precio_unitario_pen', $precio_unitario_pen);
        $this->db->set('cantidad', $cantidad);
        $this->db->set('sugerencias', $sugerencias);
        $this->db->where('pedido_id', $pedido_id);
        $this->db->where('articulo_id', $articulo_id);
        $this->db->update('pedidos_detalles');
        return array("success"=>true,"msg"=>"Error al actualizar el registro");       
    }

    public function insert($pedido_id,$usuario_id){
        
        $this->db->set('permiso_id', $pedido_id);
        $this->db->set('usuario_id', $usuario_id);
       
        $this->db->insert('permisos_usuarios');
        
        //$item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito");
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }
    public function delete($usuario_id){
        
            $this->db->where('usuario_id=',$usuario_id);
            $this->db->delete('permisos_usuarios');

            return array(
                "success"=>false,
                "msg"=>"registro eliminado con exito"
            );
        
       
    }
}