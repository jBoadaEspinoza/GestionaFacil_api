<?php
class APIS
{
	public static function getModalidadesDePago(){
        $m=array(
            array("id"=>1,"denominacion"=>"efectivo","color"=>"#2CA916"),
            array("id"=>2,"denominacion"=>"tarjeta","color"=>"#C32215"),
            array("id"=>3,"denominacion"=>"yape","color"=>"#6F16A9"),
            array("id"=>4,"denominacion"=>"plin","color"=>"#1674A9"),
            array("id"=>5,"denominacion"=>"deposito","color"=>"#2CA916")   
        );
        return $m;
    }
    public static function getInsumosTipos(){
        $m=array(
            array("id"=>1,"denominacion"=>"insumo principal"),
            array("id"=>2,"denominacion"=>"marca"),
            array("id"=>3,"denominacion"=>"otros")   
        );
        return $m;
    }
    public static function getInsumosTipo($id){
        $tipos=self::getInsumosTipos();
        foreach($tipos as $index=>$m){
            if($m["id"]==$id){
                return $m;
            }
        }
    }
    public static function getModalidadDePago($id){
        $modalidades=self::getModalidadesDePago();
        foreach($modalidades as $index=>$m){
            if($m["id"]==$id){
                return $m;
            }
        }
    }
    public static function getRUC($number){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dniruc.apisperu.com/api/v1/ruc/'.$number.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImozYW4yMUBnbWFpbC5jb20ifQ.XRg5EtGtdoIqVeWLNhpvRKAVkGCXO4IWQBd0g-mfa2A'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        $data = curl_exec($ch); 
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
       
        if($info==200){
            $data=json_decode($data,true); 
            $data["success"]=true;
            return $data;
        }
        return array("success"=>false,"msg"=>"ingrese un numero de documento valido");
    }
	public static function getDNI($number){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dniruc.apisperu.com/api/v1/dni/'.$number.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImozYW4yMUBnbWFpbC5jb20ifQ.XRg5EtGtdoIqVeWLNhpvRKAVkGCXO4IWQBd0g-mfa2A'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        $data = curl_exec($ch); 
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
       
        if($info==200){
            $data=json_decode($data,true); 
            $data["success"]=true;
            return $data;
        }
        return array("success"=>false,"msg"=>"ingrese un numero de documento valido");
    }
    
    
    public static function sendWhatsapp($to,$msg){
        $data=array("phone"=>$to,"body"=>$msg);
        $json=json_encode($data);
        $CHAT_URL="https://api.chat-api.com/instance278016/";
        $TOKEN="boid37f6mvy3uokk";
        $url=$CHAT_URL.'sendMessage?token='.$TOKEN;
        $options=stream_context_create([
            'http'=>[
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' =>$json
            ]
        ]);

        $result= file_get_contents($url,false,$options);
        if ($result) return json_decode($result,true);
        return false;
    }
    public static function sendVoucherByWhatsapp($to,$pdfdoc,$code){
        //$to="+51944627647";
		$parameters=array(
            "phone"=>$to,
            "body"=>"data:application/pdf;base64,".base64_encode($pdfdoc),
            "filename"=>"BOOKING_TRAVEL_".$code.".pdf"
        );

		$ch = curl_init();
		$CHAT_URL="https://api.chat-api.com/instance278405/";
        $TOKEN="ou8bl8iy4ssq49o7";
        $url=$CHAT_URL.'sendFile?token='.$TOKEN; 

		$headers2 = array(
			"content-type: application/json",
		);  

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$data = curl_exec($ch); 
        curl_close($ch);
        return json_decode($data,true); 
    }   
}