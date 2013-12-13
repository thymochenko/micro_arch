<?php
class ConfigSmarty extends ConfigTemplate
{
    public static $smarty_conf;
	
    public static function _setConfig(array $smarty_conf)
	{
	    self::$smarty_conf = $smarty_conf;
	}
	
	public function compilerMod()
	{
	    return self::$smarty_conf['smarty_config']['smarty_compiler_mod'];
	}
}
?>
