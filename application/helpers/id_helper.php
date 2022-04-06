<?php
class IDS{
    public static function get_environment($id){
        $id_array=explode('_', $id);
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
}