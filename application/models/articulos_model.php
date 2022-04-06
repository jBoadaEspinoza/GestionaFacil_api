<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            $this->db->distinct();
            $this->db->select('articulos.id,productos.id as producto_id,productos.denominacion as producto_denominacion,preposiciones.id as preposicion_id,preposiciones.denominacion as preposicion_denominacion,presentaciones.id as presentacion_id,presentaciones.denominacion as presentacion_denominacion,categorias.id as categoria_id,categorias.denominacion_por_unidad as categoria_denominacion_por_unidad,categorias.denominacion_por_grupo as categoria_denominacion_por_grupo,articulos.precio_pen,articulos.stock,articulos.tiempo_despacho_min,articulos.imagen_url,categorias.establecimiento_id,categorias.id as categoria_id,articulos.descripcion');
            $this->db->from('articulos');
            $this->db->join('productos', 'productos.id = articulos.producto_id');
            $this->db->join('presentaciones', 'presentaciones.id = articulos.presentacion_id');
            $this->db->join('preposiciones', 'preposiciones.id = articulos.preposicion_id');
            $this->db->join('categorias','categorias.id = articulos.categoria_id');

            if(isset($filtros["id"])){
                $this->db->where('articulos.id=',$filtros["id"]);   
            }
            if(isset($filtros["categoria_id"]) && $filtros["categoria_id"]!=0){
                $this->db->where('categorias.id=',$filtros["categoria_id"]);
            }

            if(isset($filtros["articulo_denominacion"])){
                    $this->db->like('concat(lower(categorias.denominacion_por_unidad)," ",lower(preposiciones.denominacion)," ",lower(productos.denominacion))',$filtros["articulo_denominacion"],'both');
            
            }

            if(isset($filtros["establecimiento_id"])){
                $this->db->where('categorias.establecimiento_id=',$filtros["establecimiento_id"]);
                $this->db->where('productos.establecimiento_id=',$filtros["establecimiento_id"]);
            }
            
            if(isset($filtros["num_filas"]) && isset($filtros["fila_inicial"])){
                $this->db->limit($filtros["num_filas"],$filtros["fila_inicial"]-1);
            }
            if(isset($filtros["activo"])){
                $this->db->where('articulos.activo=',$filtros["activo"]);
            }else{
                $this->db->where('articulos.activo=',1);
            }
           
            $this->db->order_by('articulos.fecha_de_registro', 'DESC');
            $this->db->order_by('articulos.ultima_actualizacion', 'DESC');
            
            $query = $this->db->get(); 

            if($query->num_rows()>=0){
                $result=$query->result_array();
               
                foreach($result as $index=>$r){    
                    switch($r["preposicion_id"]){
                        case 1:
                            $result[$index]["denominacion"] = ucfirst($r["categoria_denominacion_por_unidad"].' '.$r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;
                        case 2:
                            $result[$index]["denominacion"] = ucfirst($r["producto_denominacion"].' '.$r["categoria_denominacion_por_unidad"].' - '.$r["presentacion_denominacion"]);
                            break;
                        case 3:
                            $result[$index]["denominacion"] = ucfirst($r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;
                        default:
                            $result[$index]["denominacion"] = ucfirst($r["categoria_denominacion_por_unidad"].' '.$r["preposicion_denominacion"].' '.$r["producto_denominacion"].' - '.$r["presentacion_denominacion"]);
                            break;
                    }  
                }
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
    
    public function actualizar($id,$denominacion_por_unidad,$denominacion_por_grupo,$descripcion,$imagen_url,$establecimiento_id){
        $this->db->set('categoria_id', $categoria_id);
        $this->db->set('producto_id', $producto_id);
    
        $this->db->set('descripcion', $descripcion);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('establecimiento_id', $establecimiento_id);
        $this->db->set('ultima_actualizacion',DATE::getNowAccordingUTC());
        $this->db->where('id=',$id);
        $this->db->update('categorias');
        return array("success"=>false,"msg"=>"Error al actualizar el registro");       
    }

    public function insert($categoria_id,$producto_id,$presentacion_id,$preposicion_id,$precio,$stock,$tiempo_despacho_min,$descripcion,$imagen_url,$establecimiento_id){
        
        $this->db->set('categoria_id', $categoria_id);
        $this->db->set('producto_id', $producto_id);
        $this->db->set('presentacion_id',$presentacion_id);
        $this->db->set('preposicion_id',$preposicion_id);
        $this->db->set('precio_pen',$precio);
        $this->db->set('stock',$stock);
        $this->db->set('tiempo_despacho_min',$tiempo_despacho_min);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('establecimiento_tipo_id', $establecimiento_id);
        $this->db->set('fecha_de_registro',DATE::getNowAccordingUTC());
        $this->db->insert('articulos');
        
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
        $this->db->delete('categorias');

        $this->db->select('*');
        $this->db->from('categorias');
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