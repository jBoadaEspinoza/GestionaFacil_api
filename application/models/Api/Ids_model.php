<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ids_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function decode($id_encode,$db_table_name_long){
        $environment=IDS::get_environment($id_encode);
        $environment_id=CREDENTIAL::get_credential_types_array()[$environment]["id"];
        $db_table_names_array=TABLE::get_db_table_name_array();
        $db_table_name_short=$db_table_names_array[$db_table_name_long];
        $data=array($id_encode);
        $sql='select id from '.$db_table_name_long.' where '.'concat("'.$db_table_name_short.'","_","'.$environment_id.'","_",md5(id))=?;';
        $query=$this->db->query($sql,$data);
        if ($query->num_rows() === 1) {
            $result=$query->row_array();
            return $result["id"];
        }
        return 'undefined';
    }
    public function encode($id_decode,$db_table_name_long,$environment){
        if(!CREDENTIAL::is_environment($environment)){
            return null;
        }
        $data=array($id_decode);
        $sql='select id from '.$db_table_name_long.' where id=?;';
        $query=$this->db->query($sql,$data);
        if ($query->num_rows() === 1) {
            $environment_id=CREDENTIAL::get_credential_types_array()[$environment]["id"];
            $db_table_names_array=TABLE::get_db_table_name_array();
            $db_table_name_short=$db_table_names_array[$db_table_name_long];
            return $db_table_name_short.'_'.$environment_id.'_'.md5($id_decode);
        }
        return 'undefined';
    }
}