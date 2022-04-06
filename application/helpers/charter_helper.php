<?php
class CHARTER
{
    public static function create($data,$target){
        if ( ! function_exists('load'))
        {
            $CI =& get_instance();
            $CI->load->library('phpmailer_lib');
            $email=$CI->phpmailer_lib->load();
        }
    }
}