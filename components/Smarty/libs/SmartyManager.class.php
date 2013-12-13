<?php
class SmartyManager extends Smarty 
{
    #SmartyManager::creatObject()->initTemplate($this->object)->setCach(TRUE);
	#SmartyManager::creatObject($this->object)->initTemplate();
    private $property;
	private $config;
	private $cache;
	private $compiler;
	private $template;
	private $assign;
	
    public function __construct($property, $template, $assign)
	{
	    $this->property=$property;
		$this->template=$template;
		$this->assign=$assign;
	    parent::__construct();

	} 

	
	public function initTemplate()
	{
	    $this->config=$this->tplConfig();
		$this->cache=$this->tplCache();
		$this->compiler=$this->tplCompiler();
		$o=new SmartyManager($this->property, $this->template, $this->assign);
		$o->config_dir="{$this->config}";
	    $o->cache_dir="{$this->cache}";
	    $o->compile_dir="{$this->compiler}";
		
		
	}
	
	public function assign()
	{
	    parent::assign($this->property, $this->assign);
	}
	
	public function display()
	{
	    parent::display($this->template);
	}
	
	public function tplTemplate()
	{
	    $path = TURL::BASE;
		$array['template']   = "{$path}/core/app.components/Smarty/templates";
		return $array['template'];
	}
	
	public function tplCache()
	{
	    $path = TURL::BASE;
		$array['cache']   = "{$path}/protected/views/views.{$this->property}/cache";
		return $array['cache'];
	}
	
	public function tplCompiler()
	{
	   
	    $path = TURL::BASE;
		$array['compiler']   = "{$path}/protected/views/views.{$this->property}";
		return $array['compiler'];
	}
	
	public function tplConfig()
	{
	    $path = TURL::BASE;
	    $array = array();
		$array['config']   = "{$path}/core/app.components/Smarty/config";
		return $array['config'];
	}
	
	public static function setPath()
	{
	    $path = TURL::BASE;
		return "{$path}/protected/views/views.";
		
	}
	
}
?>