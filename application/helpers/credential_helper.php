<?php
class CREDENTIAL
{
	public static function get_credential_types_array()
    {
        if (file_exists(APPPATH.'config/credential.php'))
        {
            include(APPPATH.'config/credential.php');
        }

        if (empty($credential_types) OR ! is_array($credential_types))
        {
            return null;
        }
        return $credential_types;
    }
    public static function get_environment($key_secret){
        $id_array=explode('_', $key_secret);
        if(!is_array($id_array)){
            return null;
        }
        if(count($id_array)!=3){
            return null;
        }
        $environment_id=$id_array[1];
        if(!CREDENTIAL::is_environment_id($environment_id)){
            return null;
        }
        $credentials_types_array=CREDENTIAL::get_credential_types_array();
        foreach ($credentials_types_array as $key => $value) {
            if($value["id"]==$environment_id){
                return $key;
            }
        }
        return null;
    }
    public static function get_key_type($key_secret){
        $id_array=explode('_', $key_secret);
        if(!is_array($id_array)){
            return null;
        }
        if(count($id_array)!=3){
            return null;
        }
        $key_type_id=$id_array[0];
        $credentials_types_array=CREDENTIAL::get_credential_types_array();
        foreach ($credentials_types_array as $key => $value) {
            $types=$value["types"];
            foreach ($types as $k_type => $v_type) {
                if($key_type_id==$v_type){
                    return $k_type;
                }
            }
        }
        return null;
    }
    public static function get_environment_id($environment){
        $id=CREDENTIAL::get_credential_types_array()[$environment]["id"];
        if(isset($id)){
            return $id;
        }
        return null;
    }
    public static function is_environment($environment){
        $i=0;
        foreach (CREDENTIAL::get_credential_types_array() as $key => $value) {
            if(strtolower($key)!=strtolower($environment)){
                $i++;
            }
        }
        if($i==count(CREDENTIAL::get_credential_types_array())){
            return false;
        }
        return true;
    }
    public static function is_environment_id($environment_id){
        $i=0;
        foreach (CREDENTIAL::get_credential_types_array() as $key => $value) {
            if(strtolower($value["id"])!=strtolower($environment_id)){
                $i++;
            }
        }
        if($i==count(CREDENTIAL::get_credential_types_array())){
            return false;
        }
        return true;
    }
}