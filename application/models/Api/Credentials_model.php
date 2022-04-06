<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credentials_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function find($id){
         if(is_null($id)){
            return array(
                "message"=>"Expected KEY ID.",
                "success"=>false,
                "status"=>REST_Controller::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
        $query=$this->db->select('*')->from('key')->where('id',$id)->get();
        if ($query->num_rows() === 1) {
            $result=$query->row_array();
            return array(
                    "success"=>true,
                    "data"=>$result);
        }
        return array(
            "message"=>"Key not found.",
            "success"=>false,
            "status"=>REST_Controller::HTTP_NOT_FOUND,
        );
    }
    public function create($credentialData,$secret_key){
        $credential_types_array=CREDENTIAL::get_credential_types_array();
        $key_id=$credential_types_array[$credentialData["environment"]]["types"][$credentialData["type"]].'_'.$credential_types_array[$credentialData["environment"]]["id"].'_';

        $query=$this->db->select('*')->from('key')->where('business_id='.$credentialData["business_id"].' and id like "'.$key_id.'%"')->get();
        if ($query->num_rows() === 1) {
            $result=$query->row_array();
            return array(
                    "message"=>strtoupper($credentialData["type"]).' KEY already was created.',
                    "success"=>false,
                    "status"=>422);
        }

        if($credentialData["type"]=='private'){
            $type=true;
        }else{
            $type=false;
        }
        $url="https://api.jsonbin.io/b";
        $data_string = json_encode($credentialData);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'secret-key: '.$secret_key,
            'private:' .$type,
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_decode(curl_exec($ch),true);
        if($result["success"]==false){
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $result["status"]=$http_code;
        }else{
            $credential_types_array=CREDENTIAL::get_credential_types_array();
            $key_id=$credential_types_array[$credentialData["environment"]]["types"][$credentialData["type"]].'_'.$credential_types_array[$credentialData["environment"]]["id"].'_'.$result["id"];
            $this->db->insert('key',array("id"=>$key_id,"business_id"=>$result["data"]["business_id"]));
        }
        curl_close($ch);
        return $result;
    }
}