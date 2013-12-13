<?php
class SessionRegistry
{
    function __construct()
	{
	    session_start();
	}
	
	function setValue($key, $value)
	{
	    $_SESSION[$key]=$value;
	}
	
	function getValue($key)
	{
	    if(isset($_SESSION[$key]))
		{
	        return $_SESSION[$key]; 
		}
		else
		{
		    return false;
		}
	}
	
	function setObject($key,$obj)
	{
	    if(is_object($obj)):
		    $_SESSION[$key][$obj]=$obj;
		endif;
	}
	
	function getObject($key)
	{
	    self::getValue($key);
	}
	
	function freeSession()
	{
	    $_SESSION=array();
	    session_destroy();
	}
}




