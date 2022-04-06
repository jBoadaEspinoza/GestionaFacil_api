<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PedidosDetalles_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->select('pedido_id,precio_unitario_pen,cantidad,sugerencias,articulos.id as articulo_id,productos.id as producto_id,productos.denominacion as producto_denominacion,preposiciones.id as preposicion_id,preposiciones.denominacion as preposicion_denominacion,presentaciones.id as presentacion_id,presentaciones.denominacion as presentacion_denominacion,categorias.id as categoria_id,categorias.denominacion_por_unidad as categoria_denominacion_por_unidad,categorias.denominacion_por_grupo as categoria_denominacion_por_grupo,articulos.precio_pen,articulos.stock,articulos.tiempo_despacho_min,articulos.imagen_url,categorias.establecimiento_id,categorias.id as categoria_id,articulos.descripcion');
            $this->db->from('pedidos_detalles');
            $this->db->join('articulos','pedidos_detalles.articulo_id=articulos.id');
            $this->db->join('productos', 'productos.id = articulos.producto_id');
            $this->db->join('presentaciones', 'presentaciones.id = articulos.presentacion_id');
            $this->db->join('preposiciones', 'preposiciones.id = articulos.preposicion_id');
            $this->db->join('categorias','categorias.id = articulos.categoria_id');

            if(isset($filtros["pedido_id"])){
                $this->db->where('pedidos_detalles.pedido_id=',$filtros["pedido_id"]);   
            }
            if(isset($filtros["establecimiento_id"])){
                $this->db->where('categorias.establecimiento_id=',$filtros["establecimiento_id"]);
                $this->db->where('productos.establecimiento_id=',$filtros["establecimiento_id"]);
            }
            if(isset($filtros["pedido_id"])){
                $this->db->where('pedidos_detalles.pedido_id=',$filtros["pedido_id"]);
            }
            if(isset($filtros["articulo_id"])){
                $this->db->where('pedidos_detalles.articulo_id=',$filtros["articulo_id"]);
            }
            if(isset($filtros["num_filas"]) && isset($filtros["pagina"]) && isset($filtros["fila_inicial"])){
                $this->db->limit($filtros["num_filas"],$filtros["fila_inicial"]-1);
            }                       
            $query = $this->db->get(); 

            if($query->num_rows()>=0){
                $result=$query->result_array();
                foreach($result as $index=>$r){
                     
                    switch($r["preposicion_id"]){
                        case 1:
                            $result[$index]["articulo_denominacion"] = ucfirst($r["categoria_denominacion_por_unidad"].' '.$r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;
                        case 2:
                            $result[$index]["articulo_denominacion"] = ucfirst($r["producto_denominacion"].' '.$r["categoria_denominacion_por_unidad"].' - '.$r["presentacion_denominacion"]);
                            break;
                        case 3:
                            $result[$index]["articulo_denominacion"] = ucfirst($r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;
                        default:
                            $result[$index]["articulo_denominacion"] = ucfirst($r["categoria_denominacion_por_unidad"].' '.$r["preposicion_denominacion"].' '.$r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;    
                        }  
                }
                return array(
                    "success"=>true,
                    "data"=>$result
                );
            }

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
    public function actualizar($pedido_id,$articulo_id,$precio_unitario_pen,$cantidad,$sugerencias){
        
        $this->db->set('precio_unitario_pen', $precio_unitario_pen);
        $this->db->set('cantidad', $cantidad);
        $this->db->set('sugerencias', $sugerencias);
        $this->db->where('pedido_id', $pedido_id);
        $this->db->where('articulo_id', $articulo_id);
        $this->db->update('pedidos_detalles');
        return array("success"=>true,"msg"=>"Error al actualizar el registro");       
    }

    public function insert($pedido_id,$articulo_id,$precio_unitario_pen,$cantidad,$sugerencias=""){
        
        $this->db->set('pedido_id', $pedido_id);
        $this->db->set('articulo_id', $articulo_id);
        $this->db->set('precio_unitario_pen', $precio_unitario_pen);
        $this->db->set('cantidad', $cantidad);
        $this->db->set('sugerencias', $sugerencias);

        $this->db->insert('pedidos_detalles');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");

    }
    public function delete($pedido_id,$articulo_id){
        
        $this->db->select('*');
        $this->db->from('pedidos_detalles');
        $this->db->where('pedido_id=',$pedido_id);
        $this->db->where('articulo_id=',$articulo_id);
    

        $query = $this->db->get(); 
        if($query->num_rows()>0){
            
            $this->db->where('pedido_id=',$pedido_id);
            $this->db->where('articulo_id=',$articulo_id);
            $this->db->delete('pedidos_detalles');

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