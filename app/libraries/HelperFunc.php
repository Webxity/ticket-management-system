<?php
namespace Webxity ; 
use Validator; 

class HelperFunc {
    
//Helper functions here

    public static function get_date($date) 
    {
         
         echo date_format($date, 'j M Y ( g:i a ) ');

    }
    
    public static function url_check($url)
    {
        $findme   = 'http://';
        $pos = strpos($url, $findme);
        
        
        if(empty($pos)) 
        {
          
                    return  str_replace($findme , '' , $url ); 
        }
        else 
            return $url;
        
     }    

     
}