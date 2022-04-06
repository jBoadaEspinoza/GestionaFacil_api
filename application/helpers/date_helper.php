<?php
class DATE
{
    public static function getMonths($lang='es',$size='s'){
        $months=array(
            "es"=>array(
                "s"=>array("1"=>"ene","2"=>"feb","3"=>"mar","4"=>"abr","5"=>"may","6"=>"jun","7"=>"jul","8"=>"ago","9"=>"set","10"=>"oct","11"=>"nov","12"=>"dic"),
                "l"=>array("1"=>"enero","2"=>"febrero","3"=>"marzo","4"=>"abril","5"=>"mayo","6"=>"junio","7"=>"julio","8"=>"agosto","9"=>"setiembre","10"=>"octubre","11"=>"noviembre","12"=>"diciembre")
            )
        );
        return $months[$lang][$size];
    }
    public static function getDayOfTheWeek($lang='es',$size='s'){
        $daysOfTheWeek=array(
            "es"=>array(
                "s"=>array("1"=>"lun","2"=>"mar","3"=>"mié","4"=>"jue","5"=>"vie","6"=>"sáb","7"=>"dom"),
                "l"=>array("1"=>"lunes","2"=>"martes","3"=>"miércoles","4"=>"jueves","5"=>"viernes","6"=>"sábado","7"=>"domingo")
            )
        );
        return $daysOfTheWeek[$lang][$size];
    }
	public static function getNowAccordingUTC(){
        return gmdate('Y-m-d H:i:s');
    }
	public static function convertDateTimeAccordingTimeZone($dateTime,$timeZone){
        return  new DateTime($dateTime->format("Y-m-d h:i:s"), new DateTimeZone($timeZone));
    }
    public static function convertUTCToDateTimeZone($dateUTC,$timeZone='America/Lima'){
        date_default_timezone_set('UTC');
        $dt = new DateTime($dateUTC);
        $dt->setTimezone(new DateTimeZone($timeZone));
        return $dt; 
    }
    public static function getTomorrow($date){
    	$datetime = new DateTime($date->format('Y-m-d'));
		$datetime->modify('+1 day');
		return $datetime;
    }
    public static function getTimeElapsed($diff){
        $minutes=floor($diff/60);
        if($minutes>60){
            //horas
            $horas=floor($minutes/60);
            if($horas>24){
                $dias=floor($horas/24);
                if($dias>30){
                    $mes=floor($dias/30);
                    if($mes>12){
                        $anho=floor($mes/12);
                        if($anho>1){
                           return abs($anho).' años'; 
                       }else{
                            return abs($anho).' año';
                       }
                        
                    }else{
                        if($mes>1){
                            return abs($mes).' meses '.($dias-($mes*30)).'d';
                        }else{
                            return abs($mes).' mes '.($dias-($mes*30)).'d';
                        }
                    }    
                }else{
                    return abs($dias).'d '.($horas-($dias*24)).'h';
                }
            }else{
                return abs($horas).'h '.($minutes-($horas*60)).'min';
            }
            
        }else{
            return abs($minutes).'min'; 
        }
    }
}