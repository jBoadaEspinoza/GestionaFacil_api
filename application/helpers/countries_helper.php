<?php
class COUNTRIES
{
	private static function Load()
    {
        $path="assets/jsons/countries.json";
        return json_decode(file_get_contents($path),true);
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
}