<?php class ConfigLogger extends GlobalConfig
{
    private static $log;
	
	public static function _setConfig(array $log)
	{
	    self::$log = $log;
	}
	
    public static function _getConfig()
	{
	    return new ConfigLogger;
	}
	
	public static function start()
	{
	    return self::$log['log']['start_log'];
	}
	
	public static function _HTML()
	{
	    return self::$log['log']['path_html'];
	}
	
	
	public static function _XML()
	{
	    return self::$log['log']['path_xml'];
	}
	
	
	public static function _TXT()
	{
	    return self::$log['log']['path_txt'];
	}
}
?>
