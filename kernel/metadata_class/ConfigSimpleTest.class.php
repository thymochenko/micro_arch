<?php
class ConfigSimpleTest extends GlobalConfig
{
    private static $simple_test_conf;
	
	public static function _setConfig(array $simple_test_conf)
	{
	   self::$simple_test_conf = $simple_test_conf;
	}
	
	public static function _getConfig()
	{
	    return new ConfigSimpleTest;
	}
	
	public static function simpleTestPathLoad()
	{
	    return self::$simple_test_conf['simple_test_config']['simple_test_path_load'];
	}
    
	public static function load()
	{
	    return self::$simple_test_conf['simple_test_config']['load'];
	}
	
	public static function loadSuiteTest()
	{
        if(self::$simple_test_conf['simple_test_config']['load'] == true)
		{
	        $base = ConfigPath::AppCore();
	        include_once $base . '/components/simpletest/autorun.php';
		}
	}
}
?>
