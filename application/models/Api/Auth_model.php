<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api/credentials_model');
    }
    public function get_authorization(){
        $validate=AUTHORIZATION::validate();
        //valida header
        if(!$validate["success"]){
            return array(
                "success"=>false,
                "message"=>$validate["message"],
                "status"=>$validate["status"]
            );
        }
        //obtiene key secret
        $key_secret=$validate["key_secret"];
        $key_secret_type=CREDENTIAL::get_key_type($key_secret);
        //valida que key sea private
        if($key_secret_type!='private'){
            return array(
                "success"=>false,
                "message"=>"Error 422: Expected PRIVATE KEY.",
                "status"=>REST_Controller::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        //Obtenemos credenciales segun key secret
        $objCredential=$this->credentials_model->find($key_secret);
        if(!$objCredential["success"]){
            return array(
                "success"=>false,
                "message"=>$objCredential["message"],
                "status"=>$objCredential["status"]
            );
        }
        return array(
            "success"=>true,
            "data"=>array(
                    "environment"=>array(
                        "id"=>CREDENTIAL::get_environment_id(CREDENTIAL::get_environment($key_secret)),
                        "name"=>CREDENTIAL::get_environment($key_secret)
                    ),
                    "business"=>array(
                        "id"=>$objCredential["data"]["business_id"]
                    )
            )
        );
    }
    public function create($objToken,$objClient,$objUser=null){
        $query = $this->db->select('*')->from('token')->where('id',$objToken["id"])->get();
        if ($query->num_rows() == 0) {
            $result_client_index=1;
            $result_user_index=1;
            //Evaluamos que el cliente no este registrado
            $query=$this->db->select('*')->from('client')->where('id',$objClient["id"])->get();
            if($query->num_rows() == 0){
                //Registramos el cliente
                $str = $this->db->insert_string('client',$objClient);
                $result_client_index = $this->db->query($str); //Puede ser 1/0
                if($result_client_index==1){
                    //agregamos atrbuto client_id al objeto token
                    $objToken["client_id"]=$objClient["id"];
                }
            }else{
                //agregamos atrbuto client_id al objeto token
                $objToken["client_id"]=$objClient["id"];
            }
            //Evaluamos al usuario
            if(!is_null($objUser)){
                $query=$this->db->select('*')->from('user')->where('id',$objUser['id'])->get();
                if($query->num_rows() == 0){
                    //Registramos al usuario 
                    $str = $this->db->insert_string('user',$objUser);
                    $result_user_index = $this->db->query($str); 
                    if($result_user_index==1){
                        //Agregamos atributo user_ud a objeto token
                        $objToken["user_id"]=$objUser["id"];
                    } 
                }
            }
            if($result_user_index==1 && $result_client_index==1){
                $str=$this->db->insert_string('token',$objToken);
                $result_token_index=$this->db->query($str);
                if($result_token_index==1){
                    return array(
                        "status"=>REST_Controller::HTTP_CREATED,
                        "data"=>array(
                            "object"=>'token',
                            "id"=>$objToken["id"],
                            "type"=>JWT::GetType($objUser)["name"],
                            "date_created"=>$objToken["date_created"],
                            "date_expiration"=>$objToken["date_expiration"],
                            "client"=>$objClient,
                            "user"=>$objUser
                        )
                    );
                }
            }
        }else{
            if ($query->num_rows() === 1) {
                $result=$query->row_array();
                $query=$this->db->select('*')->from('client')->where('id',$result["client_id"])->get();
                if($query->num_rows() === 1){
                    $objClient=$query->row_array();
                }
                $objToken=array(
                    "object"=>"token",
                    "id"=>$result["id"],
                    "type"=>JWT::GetType($objUser)["name"],
                    "date_created"=>$result["date_created"],
                    "date_expiration"=>strval(time()+(JWT::GetType($objUser)['time_expiration_min']*60)),
                    "client"=>$objClient,
                    "user"=>$objUser
                );
                return array(
                    "status"=>REST_Controller::HTTP_OK,
                    "data"=>$objToken
                );
            }
        }
    }
    public function validate($token){
        $decodedToken = JWT::decode($token,$this->config->item('jwt_key'));
        $time=time();
        if($time > $decodedToken->date_expiration){
            return REST_Controller::HTTP_UNAUTHORIZED;
        }
        if(CLIENT::GetId() != $decodedToken->client->id){
            return REST_Controller::HTTP_UNAUTHORIZED;
        }
        return REST_Controller::HTTP_OK;
    }
}