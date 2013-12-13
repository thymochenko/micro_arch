<?php
class SingleSmarty extends Smarty 
{ 
    private static $_instance; 

    public function __construct()
	{
	    parent::__construct();
	} 

    static function createInstance() 
    { 
        self::$_instance=new SingleSmarty();
       
        return self::$_instance; 
    } 
	/*
	*method setInitializers($objtemp)
    *diretivas de cache
	*checa se o houve uma alteraзгo no template padrгo e atualiza versгo do template
	*SingleSmarty::getInstance()->caching = 1;
	*SingleSmarty::getInstance()->cache_lifetime = 5;
	*debug
	*SingleSmarty::getInstance()->debugging = TRUE;
	*variбveis de conf com paths
	*/
	public function setInitializers($objtemp){
	   
		SingleSmarty::getInstance()->compile_check = ConfigSmarty::compilerMod();
		
		$config  =  SingleSmarty::tplConfig();
		$cache  = SingleSmarty::tplCache();
		$compiler = SingleSmarty::tplCompiler($objtemp);
		#diretrizes de configuraзгo
	    SingleSmarty::getInstance()->config_dir  =   "{$config}";
	    SingleSmarty::getInstance()->cache_dir   =   "{$cache}";
	    SingleSmarty::getInstance()->compile_dir =   "{$compiler}";
	}
	
	public static function getInstance()
	{
	    return self::$_instance;
	}
	
	public function tplTemplate()
	{
	    $path = ConfigPath::pathAppBase();
		
	    $array = array();
		$array['template']   = "{$path}/core/app.components/Smarty/templates";
		return $array['template'];
	}
	
	public function tplCache()
	{
	    $path = ConfigPath::pathAppBase();
	    $array = array();
		$array['cache']   = "{$path}/protected/cache";
		return $array['cache'];
	}
	
	public function tplCompiler($objtemp)
	{
	    $path = ConfigPath::pathAppBase();
	    $array = array();
		//path dentro do diretуrio de views
		$array['compiler']   = "{$path}/protected/views/views.{$objtemp}";
		return $array['compiler'];
	}
	
	public function tplConfig()
	{
	    $path = ConfigPath::pathAppBase();
	    $array = array();
		$array['config']   = "{$path}/cache/app.components/Smarty/config";
		return $array['config'];
	}
}
?>