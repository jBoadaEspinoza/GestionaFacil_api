<?php
class MAILER
{
    public static function send($to,$to_name,$from,$from_password,$from_title,$subject,$message){
        if ( ! function_exists('load'))
        {
            $CI =& get_instance();
            $CI->load->library('phpmailer_lib');
            $email=$CI->phpmailer_lib->load();
        }
        $CI =& get_instance();
        $CI->load->library('phpmailer_lib');
        $email=$CI->phpmailer_lib->load();

        $email->IsSMTP();
        $email->SMTPAuth = true;
        $email->SMTPSecure = 'tls';
        $email->Host = "smtp.gmail.com";
        $email->Port = 587;
        $email->Username   = $from;
        $email->Password   = $from_password;
        $email->SetFrom($from,$from_title);
        $email->AddReplyTo($from,$from_title);
        $email->AddAddress($to, $to_name);
        $email->Subject = $subject;
        $email->MsgHTML($message);
        //$email->AddAttachment("images/phpmailer.gif");
        if(!$email->Send()) {
          return  false;
        } else {
          return true;
        }
    }
}