<?php
namespace ZendVN\Url;
class CurrentDomain{
    
    public static function get(){
        $pageURL = 'http';
        if (!empty($_SERVER['HTTPS'])) {if($_SERVER['HTTPS'] == 'on'){$pageURL .= "s";}} 
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];
        }
        return $pageURL;
    }

}