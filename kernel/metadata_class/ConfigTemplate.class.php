<?php
class ConfigTemplate extends GlobalConfig
{
    private static $template_conf;
	
	public static function _setConfig(array $template_conf)
	{
	    self::$template_conf = $template_conf;
	}
	
	public static function _getConfig()
	{
	    return new ConfigTemplate;
	}
	
	public static function dafaultTemplate()
	{
	    return self::$template_conf['global_conf_template']['default_template'];    
	}
}
?>
