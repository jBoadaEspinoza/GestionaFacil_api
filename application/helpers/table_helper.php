<?php
class TABLE
{
	public static function get_db_table_name_array()
    {
        if (file_exists(APPPATH.'config/table.php'))
        {
            include(APPPATH.'config/table.php');
        }

        if (empty($db_tables_name) OR ! is_array($db_tables_name))
        {
            return array();
        }
        return $db_tables_name;
    }
    public static function get_table_name_short($table_name_long){
        $db_table_name_array=TABLE::get_db_table_name_array();
        $table_name_short=$db_table_name_array[$table_name_long];
        if(isset($table_name_short)){
            return $table_name_short;
        }
        return null;
    }
	public static function encrypt_ids_table($object,$object_name,$environment_id){
        $obj=$object;
        foreach ($obj as $key => $value) {
            if($key=='id'){
                $new_obj[$key]=self::get_table_name_short($object_name).'_'.$environment_id.'_'.md5($value);
            }else{
                if(strpos($key,'_id') && preg_match('/^[0-9]+$/', $value)){
                    $new_key=substr($key, 0,-3);
                    $new_obj[$new_key]=self::get_table_name_short($new_key).'_'.$environment_id.'_'.md5($value);
                }else{
                    $new_obj[$key]=$value;
                }
            }
        }
        return $new_obj;
    }
}