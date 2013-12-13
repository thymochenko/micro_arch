<?php
class ConfigCache extends GlobalConfig
{
    public static $cache;
	/*
	*setters
	*/
	public static function _setConfig(array $cache)
	{
	    self::$cache = $cache;
	}
	
	/*
	*getters
	*/
	
	public static function _getConfig()
	{
	    return new ConfigCache;
	}
	
	public static function cachePath()
	{
	    return self::$cache['cache_path'];
	}
	
	public static function cacheLoadMethodId($paran)
	{
	    if($paran=='load')
		{
	        return self::$cache['cache_load_method_id']['load'];
		}
		if($paran='findBySql')
		{
		    return self::$cache['cache_load_method_id']['findBySql'];
		}
	}
	
	public static function cacheDefaultLifeTime()
	{
	    return self::$cache['cache_default_life_time'];
	}
	
}
