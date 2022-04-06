<?php
class CLIENT
{
	public static function GetIp(){
		$CI =& get_instance();
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if($_SERVER["HTTP_HOST"]=='localhost'){
          $ip=$CI->config->item('client_ip');  
        }
        return $ip;
	}
	public static function GetCountryCode($ip = null){
		if(is_null($ip)){
			$ip=self::GetIp();
		}
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        return $details->country;
	}
	public static function GetBrowser(){
		$arr_browsers = ["Firefox", "Chrome", "Safari", "Opera", "MSIE", "Trident", "Edge"];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$user_browser = '';
		foreach ($arr_browsers as $browser) {
		    if (strpos($agent, $browser) !== false) {
		        $user_browser = $browser;
		        break;
		    }   
		}
		switch ($user_browser) {
		    case 'MSIE':
		        $user_browser = 'Internet Explorer';
		        break;
		 
		    case 'Trident':
		        $user_browser = 'Internet Explorer';
		        break;
		 
		    case 'Edge':
		        $user_browser = 'Internet Explorer';
		        break;
		}
		return $user_browser;
	}
	public static function GetId(){
		$uid="";
		$uid.=self::GetIp();
		$uid.=@$_SERVER['HTTP_USER_AGENT'];
		$uid.=gethostname();
		return sha1($uid);
	}
	public static function GetDeviceType(){
		$tablet_browser = 0;
        $mobile_browser = 0;
        $body_class = 'desktop';
         
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
            $body_class = "tablet";
        }
         
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
         
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
         
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');
         
        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
         
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
              $tablet_browser++;
            }
        }
        if ($tablet_browser > 0) {
        // Si es tablet has lo que necesites
           return 'table';
        }
        else if ($mobile_browser > 0) {
        // Si es dispositivo mobil has lo que necesites
           return 'mobile';
        }
        else {
        // Si es ordenador de escritorio has lo que necesites
           return 'pc';
        }  
	}
}
