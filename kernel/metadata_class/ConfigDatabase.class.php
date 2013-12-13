<?php
class ConfigDatabase extends GlobalConfig
{
    public static $database;	
	/*
	*setters
	*/
	public static function _setConfig(array $database)
	{
	    self::$database = $database;
	}
	
	/*
	*getters
	*/
	
	public static function _getConfig()
	{
	    return new ConfigDatabase;
	}
	
	public static function database()
	{
	    return self::$database['config_database']['database'];
	}
}
?>
