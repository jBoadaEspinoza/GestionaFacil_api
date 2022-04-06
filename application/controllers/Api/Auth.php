<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 * 
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('auth_model');
    }
    public function index_post(){

        $CI =& get_instance();
        $time = time();

        $objUser=array(
            "date_created"=>$time,
            "date_expiration"=>$time+(5*60),
            "usuario_id"=>43039156
        );

        $token=JWT::encode($objUser,$CI->config->item('jwt_key'));
        $output["response"]["status"]=true;
        $output["response"]["token"]=$token;

        $this->set_response($output,200);
    }
    
}