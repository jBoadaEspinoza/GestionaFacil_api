<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('establecimientosTipos_model');
        $this->load->model('personas_model');
        $this->load->model('permisosUsuarios_model');
    }
    
    public function get($filtros=null)
    {
        if(!is_null($filtros)){
            
            $this->db->distinct();
            $this->db->select('usuarios.id as id,nombre,clave_acceso,personas.id as persona_id,personas.nombres as persona_nombres,personas.apellidos as persona_apellidos,roles.id as rol_id,roles.denominacion as rol_denominacion,usuarios.activo');
            $this->db->from('usuarios');
            $this->db->join('roles','roles.id=usuarios.rol_id');
            $this->db->join('personas','personas.id=usuarios.persona_id');
            
            if(isset($filtros["id"])){
                $this->db->where('usuarios.id=',$filtros["id"]);   
            }
            if(isset($filtros["rol_id"])){
                $this->db->where('roles.id=',$filtros["rol_id"]);
            }
            if(isset($filtros["nombre"])){
                $this->db->where('usuarios.nombre=',$filtros["nombre"]);
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
                "msg"=>"cajas no encontradas",
            ); 
        }
    }
    public function insert($nombre_usuario,$clave_acceso,$persona_id,$rol_id,$establecimiento_id,$activo=1){
        $this->db->set('nombre', $nombre_usuario);
        $this->db->set('clave_acceso', md5($clave_acceso));
        $this->db->set('persona_id', $persona_id);
        $this->db->set('rol_id', $rol_id);
        $this->db->set('establecimiento_id', $establecimiento_id);
        $this->db->set('activo', $activo);
        $this->db->insert('usuarios');
        
        $item_id=$this->db->insert_id();

        if($this->db->trans_status()){
            $this->db->trans_commit();
            return array("success"=>true,"msg"=>"Registro guardado con exito","id"=>$item_id);
         
        }
        $this->db->trans_rollback();
        return array("success"=>false,"msg"=>"Error al guardar el registro");
    }
    public function change_password($business_id,$user_name,$user_password_old,$user_password_new){
        $data=self::is_password_correct($business_id,$user_name,$user_password_old);
        if($data["success"]){
            if($data["user_type"]=="admin"){
                //actualizacion usuario admin
                $this->db->set('propietario_clave_acceso', $user_password_new);
                $this->db->where('id=',$business_id);
                $this->db->update('establecimientos');
                return array("success"=>true,"msg"=>"Registro actualizado correctamente");
            }else{
                //codigo para actualizacion otro tipo de usuario
            }
        }
    }

    public function is_password_correct($business_id,$user_name,$user_password){
        
        $this->db->select('propietario_clave_acceso');
        $this->db->from('establecimientos');
        $this->db->where('establecimientos.id=',$business_id);
        //si usuario es administrador 
        $this->db->where('establecimientos.propietario_correo_electronico=',$user_name);
        //si usuario no es administrador evaluara....

        //
        $query=$this->db->get();

        if($query->num_rows()==1){
            $result=$query->row_array();  
            $business_admin_password=$result["propietario_clave_acceso"];
            if($user_password==$business_admin_password){
                return array(
                    "success"=>true,
                    "msg"=>"Contraseña correcta",
                    "user_type"=>"admin"
                );
            }
            return array(
                "success"=>false,
                "msg"=>"Contraseña incorrecta",
            );
        }
        return array(
            "success"=>false,
            "msg"=>"Error",
        );  
    }
    
    public function validate($ruc,$name,$password,$rol_id){
        
        $this->db->select('id,nombre_comercial,activo,propietario_id,propietario_nombres,propietario_apellidos,propietario_correo_electronico,propietario_celular,propietario_clave_acceso,abierto,direccion_denominacion');
        $this->db->from('establecimientos');
        $this->db->where('establecimientos.ruc=',$ruc);
        $query_by_ruc=$this->db->get();

        //validamos si existe el establecimiento
        if($query_by_ruc->num_rows()==1){
            
            $result_by_ruc=$query_by_ruc->row_array();
            $business_id=$result_by_ruc["id"];
            $business_name=$result_by_ruc["nombre_comercial"];
            $business_active=$result_by_ruc["activo"];
            
            if($business_active==1){
                $objUsuario=self::get(array("establecimiento_id"=>$business_id,"rol_id"=>$rol_id,"nombre"=>$name));
                if(!$objUsuario["success"] || count($objUsuario["data"])==0){
                    return array(
                        "success"=>false,
                        "error_id"=>4,
                        "msg"=>"Usuario no asociado al establecimiento",
                    );
                }
                
                $usuario=$objUsuario["data"][0];
                if($usuario["activo"]==0){
                    return array(
                        "success"=>false,
                        "error_id"=>2,
                        "msg"=>"usuario inactivo",
                    ); 
                }
                $objPersona=$this->personas_model->get(array("id"=>$usuario["persona_id"]));
                
                $persona=$objPersona["data"][0];
                $business_user_person_id=$persona["id"];

                $business_user_firstnames=$persona["nombres"];
                $business_user_lastnames=$persona["apellidos"];
                $business_user_activo=$usuario["activo"];
                $business_open=$result_by_ruc["abierto"];
                
                //Es un usuario logeado
                if(md5($password)==$usuario["clave_acceso"]){
                    /*$objTipoEstablecimiento=$this->establecimientosTipos_model->get(array("establecimiento_id"=>$business_id));
                    if(!$objTipoEstablecimiento["success"]){
                        return array(
                            "success"=>false,
                            "error_id"=>5,
                            "msg"=>"Tipo de establecimiento no definido",
                        ); 
                    }
                    $tipoEstablecimiento=$objTipoEstablecimiento["data"][0];*/
                    $business_user_firstnames_array=explode(" ",$business_user_firstnames);
                    $nickname=$business_user_firstnames_array[0];

                    $objPermisos=$this->permisosUsuarios_model->get(array("usuario_id"=>$usuario["id"]));
                    
                    return array(
                        "success"=>true,
                        "data"=>array(
                            "id"=>$usuario["id"],
                            "business_id"=>$business_id,
                            "business_ruc"=>$ruc,
                            "business_name"=>strtolower($business_name),
                            "business_open"=>$business_open,
                            "business_active"=>$business_active,
                            "user_person_id"=>$business_user_person_id,
                            "user_nickname"=>strtolower($nickname),
                            "user_firstname"=>strtolower($business_user_firstnames),
                            "user_lastname"=>strtolower($business_user_lastnames),
                            "user_active"=>$business_user_activo,
                            "permisos"=>$objPermisos["data"]
                        )
                    );
                }
                return array(
                    "success"=>false,
                    "error_id"=>3,
                    "msg"=>"Contraseña incorrecta",
                );  

            }
            return array(
                "success"=>false,
                "error_id"=>2,
                "msg"=>"Establecimiento inactivo",
            );     
        }
        return array(
            "success"=>false,
            "error_id"=>1,
            "msg"=>"Establecimiento no encontrado",
        ); 

    }
    
}