<?php
class ConfigDebug extends GlobalConfig
{
    private static $debug;

    public static function _setConfig(array $debug)
	{
	    self::$debug = $debug;
	}
    
    public static function _getConfig()
	{
	    return new ConfigDebug;
	}
    
    public static function modDebug()
	{
	    return self::$debug['global_objects']['mod_debug'];
	}	
}
?>
