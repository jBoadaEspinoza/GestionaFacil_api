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

class Credentials extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('businesses_model');
        $this->load->model('Api/credentials_model');
        $this->load->model('Api/ids_model');
    }
    public function index_post(){
        //HEADER request application/json
        /*if(is_null(AUTHORIZATION::getContentTypeHeader())){
            //ERROR N°-1
            $output["response"]["message"]="Error 422: Expected Content-Type: application/json.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }
        //HEADER request authorization
        $secret_key=AUTHORIZATION::getBearerToken();
        if(is_null($secret_key)){
            //ERROR N°-2
            $output["response"]["message"]="Error 422: Expected Authorization:Bearer <<KEY-SECRET>>.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }

        //POST request
        $business_id=$this->post('business_id');//Int Value;
        $environment=$this->post('environment');//Integration|Production;
        if(is_null($environment)){
            $output["response"]["message"]="Error 422: Expected Enviroment.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }
        //
        if(!isset($business_id) || !isset($environment)){
            //ERROR N°-3
            $output["response"]["message"]="Error 422: POST REQUEST has been defined incorrectly.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }
        $business_id=$this->ids_model->encode($business_id,'affiliate_business',$environment);
        if(is_null($business_id)){
            //ERROR N°-3
            $output["response"]["message"]="Error 422: For encode Affiliate Business ID.";
            $output["response"]["success"]=false;
            $this->set_response($output,REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            return;
        }
        $objBusiness=$this->businesses_model->get($environment,$business_id);
        if($objBusiness["success"]!=1){
            //ERROR N°-4
            $output["response"]["message"]="Error ".$objBusiness["status"].": ".$objBusiness["message"];
            $output["response"]["success"]=false;
            $this->set_response($output,$objBusiness["status"]);
            return;
        }
        $credential_types_array=CREDENTIAL::get_credential_types_array();
        $credential=$credential_types_array[$environment];
        if(!isset($credential)){
            //ERROR N°-5
            $output["response"]["message"]="Error 422: environment has been defined incorrectly";
            $output["response"]["success"]=false;
            $this->set_response($output,$objBusiness["status"]);
            return;
        }
        $business_id=$this->ids_model->decode($business_id,'affiliate_business');
        if(is_null($business_id)){
            $output["response"]["message"]="Error 422: Affiliate Business ID incorrect";
            $output["response"]["success"]=false;
            $this->set_response($output,$objBusiness["status"]);
            return;
        }*/
        $credential_id=$credential["id"];
        $credential_types = $credential["types"];
        $time=time();
        $i=0;
        $e=0;
        foreach ($credential_types as $type => $id) {
            $credentialData=array(
                "business_id"=>$business_id,
                "environment"=>$environment,
                "type"=>$type,
                "date_created"=>$time
            );
            $objCredential=$this->credentials_model->create($credentialData,$secret_key);
            if($objCredential["success"]==1){
                $key=$id.'_'.$credential_id.'_'.$objCredential["id"];
                $keys[$type]=$key;
                $i++;
            }else{
                $array_msg[$e]='Error '.$objCredential["status"].': '.$objCredential["message"];
                $e++;
            }
        }
        if($i==2){
            //SUCCESS
            $output["response"]["success"]=true; 
            $output["response"]["keys"]=$keys;
        }else{
            //ERROR N°-7
            $output["response"]["message"]=implode(' | ', $array_msg);
            $output["response"]["success"]=false;
        }
        $this->set_response($output,200);
    }
}