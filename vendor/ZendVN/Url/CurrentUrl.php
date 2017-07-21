<?php
namespace ZendVN\Url;
class CurrentUrl{
    public static function get()
	{
        $pageURL = 'http';
        if (!empty($_SERVER['HTTPS'])) {if($_SERVER['HTTPS'] == 'on'){$pageURL .= "s";}} 
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"]."".$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
	}
} 
