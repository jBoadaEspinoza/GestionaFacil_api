<?php
class COUNTRY
{
	private static function Load()
    {
        $path="assets/jsons/countries.json";
        return json_decode(file_get_contents($path),true);
	}
	public static function array_countries($regions=null){
		if(is_null($regions)){
			return self::Load();
		}
		$countries=self::load();
		$new_countries=array();
		foreach($regions as $index=>$r){
			foreach($countries as $index2 =>$c){
				if($c["subregion"]==$r){
					array_push($new_countries,$c);
				}
			}
		}
		return $new_countries;
	}

	public static function get($country_code){
		$countries_loaded=self::Load();
		for($i=0;$i<count($countries_loaded);$i++){
			$country=$countries_loaded[$i];
			if(strtolower($country_code)==strtolower($country["alpha2Code"])){
				return $country;
			}
		}
	}

	public static function getLatLng($country_code){
		$country=self::get($country_code);
		return $country["latlng"];
	}

	public static function getTimeZone($lat,$lng){
		$CI =& get_instance();
        $url='https://reverse.geocoder.cit.api.here.com/6.2/reversegeocode.json?prox='.$lat.','.$lng.',100&mode=retrieveAddresses&app_id='.$CI->config->item('here_app_id').'&app_code='.$CI->config->item('here_app_code').'&gen=9&locationattributes=tz';
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL,  $url);                   
        $response = json_decode(curl_exec($ch),true);                 
        curl_close($ch);
        return $response["Response"]["View"][0]["Result"][0]["Location"]["AdminInfo"]["TimeZone"]["id"];
    }
    
    public static function getTimeZoneByIp(){
    	$country_code_from_ip = CLIENT::GetCountryCode();
		$latlng_from_ip=COUNTRY::getLatLng($country_code_from_ip);
		return self::getTimeZone($latlng_from_ip[0],$latlng_from_ip[1]);
    }
}