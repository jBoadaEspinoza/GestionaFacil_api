<?php
class CURRENCY
{
	private static function Load()
    {
        $path="assets/jsons/currencies.json";
        return json_decode(file_get_contents($path),true);
    }
	public static function get($code){
		$currencies_loaded=self::Load();
		if(isset($currencies_loaded[$code])){
			return $currencies_loaded[$code];
		}
		return null;
	}
}