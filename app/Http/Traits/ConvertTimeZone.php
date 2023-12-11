<?php

namespace App\Http\Traits;
use DateTime;
use DateTimeZone;
use Exception;
trait ConvertTimeZone {


    public $timezone, $time;
    public function convertTimeZone($timezone, $time)
    {
        try{
            $this->timezone = $timezone;
            $this->time = $time;

            $clientTime = new DateTimeZone('America/Vancouver'); 
            
            $this->_convertedTime = new DateTime($this->time,$clientTime); 
            
            $serverTime = new DateTimeZone(date_default_timezone_get()); 
            $this->_convertedTime->setTimezone($serverTime); 
            return $this->_convertedTime->format('H:i');
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

}
