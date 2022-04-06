<?php
class AUTHORIZATION
{   
    public static function getContentTypeHeader(){
        $headers=null;
        if(isset($_SERVER['CONTENT_TYPE'])){
            $headers= trim($_SERVER['CONTENT_TYPE']);
        }
        return $headers;
    }
    public static function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    public static function getBearerToken() {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
    public static function validate(){
        //HEADER request application/json
        if(is_null(self::getContentTypeHeader())){
            //ERROR N°-1
            return array(
                "message"=>"Error 422: Expected Content-Type: application/json.",
                "success"=>false,
                "status"=>REST_Controller::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        //HEADER request authorization
        $secret_key=AUTHORIZATION::getBearerToken();
        if(is_null($secret_key)){
            return array(
                "message"=>"Error 422: Expected Authorization:Bearer <<KEY-SECRET>>.",
                "success"=>false,
                "status"=>REST_Controller::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return array(
            "success"=>true,
            "key_secret"=>$secret_key
        );
    }
}