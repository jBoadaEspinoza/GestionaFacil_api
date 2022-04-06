<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){

            $this->db->distinct();
            $this->db->select('pedidos.id,pedidos.fecha_hora_emision,pedidos.mozo_id,pedidos.cliente_id,pedidos.entrega_lng,pedidos.entrega_lat,pedidos.entrega_referencia,pedidos.hora_preparacion_inicio,pedidos.forma_de_pago_id,pedidos.forma_de_pago_monto_a_entregar,pedidos.importe_productos_pen,pedidos.importe_delivery_pen,pedidos.cerrado,pedidos.referencia_a_bd');
            $this->db->from('pedidos');
            $this->db->join('pedidos_detalles','pedidos_detalles.pedido_id=pedidos.id');
            $this->db->join('articulos','pedidos_detalles.articulo_id=articulos.id');
            $this->db->join('productos', 'productos.id = articulos.producto_id');
            $this->db->join('presentaciones', 'presentaciones.id = articulos.presentacion_id');
            $this->db->join('preposiciones', 'preposiciones.id = articulos.preposicion_id');
            $this->db->join('categorias','categorias.id = articulos.categoria_id');

            if(isset($filtros["id"])){
                $this->db->where('pedidos.id=',$filtros["id"]);   
            }
            if(isset($filtros["cerrado"])){
                $this->db->where('pedidos.cerrado=',$filtros["cerrado"]);
            }
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('categorias.establecimiento_id=',$filtros["establecimiento_id"]);
                $this->db->where('productos.establecimiento_id=',$filtros["establecimiento_id"]);
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
                "msg"=>"articulos no encontradas",
            ); 
           
        }
        
        return array(
            "success"=>false,
            "msg"=>"Usuario no encontrado",
        ); 

    }
    public function insert($referencia_a_bd,$mozo_id=0,$cliente_id=0){
        $this->db->set('mozo_id',$mozo_id);
        $this->db->set('fecha_hora_emision', DATE::getNowAccordingUTC());
        $this->db->set('fecha_hora_cierre', DATE::getNowAccordingUTC());
        $this->db->set('cliente_id', $cliente_id);
        $this->db->set('referencia_a_bd', $referencia_a_bd);

        $this->db->insert('pedidos');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }   
    public function actualizar($id,$referencia_a_bd,$cliente_id=0,$cerrado=0){
        
        $this->db->set('cliente_id', $cliente_id);
        $this->db->set('referencia_a_bd', $referencia_a_bd);
        $this->db->set('fecha_hora_cierre', DATE::getNowAccordingUTC());
        $this->db->set('cerrado', $cerrado);
        $this->db->where('id=',$id);
        $this->db->update('pedidos');

        return array("success"=>true,"msg"=>"registro actualizado con exito");       
    }
    
    public function actualizar_referencia($id,$referencia_a_bd){
    
        $this->db->set('referencia_a_bd', $referencia_a_bd);
        $this->db->where('id=',$id);
        $this->db->update('pedidos');
        
        return array("success"=>true,"msg"=>"registro actualizado con exito");      
    }

    public function delete($id){
        
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->where('id=',$id);
     
        $query = $this->db->get(); 
        if($query->num_rows()>0){
            
            $this->db->where('id=',$id);
            $this->db->delete('pedidos');

            return array(
                "success"=>false,
                "msg"=>"registro eliminado con exito"
            );
        } 
        return array(
            "success"=>false,
            "msg"=>"registro no encontrado",
        ); 
    }
}