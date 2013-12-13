<?php
class ConfigMail extends GlobalConfig
{
    public static $mail;
	
	public static function _setConfig(array $mail)
	{
	    self::$mail = $mail;
	}
	
	public static function _getConfig()
	{
	    return new ConfigMail;
	}
	
	public static function host()
	{
	    return self::$mail['host'];
	}
	
	public static function username()
	{
	    return self::$mail['username'];
	}
	
	public static function password()
	{
	    return self::$mail['password'];
	}
	
	public static function addaddress()
	{
	    return self::$mail['addaddress'];
	}
}
?>
