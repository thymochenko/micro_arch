<?php
class SmartyTemplateComponent extends LoadTemplateEnginer implements Pluggable
{
    protected $cache;
	static $instance;
	
    public function __construct(array $options)
	{
	    if(empty($options['cache']))
		{
		    $this->cache = null;
		}
		else
		{
		    $this->cache = $options['cache'];
		}
		
		parent::__construct($options);	
		
		$this->initialize();
	}
	
	public function initialize()
	{
	    //pega a refer�ncia do objeto smarty na mem�ria
	    $smarty=singleSmarty::createInstance();
		//inicializa configura��e b�sicas
		self::$instance = $smarty;
		
		if($this->cache)
		{
		    $smarty->caching = $this->cache['mod'];
			$smarty->cache_lifetime = $this->cache['lifetime'];
		}
		
		$smarty->setInitializers($this->getActionReference());
		//pega path de compila��o
		$compiler=singleSmarty::tplCompiler($this->getActionReference());
		//renderiza o objeto do model para o template smarty
		$smarty->assign($this->getActionReference(), $this->collection);
		//dispacha saida.
		$smarty->display($compiler .  "/" . $this->template . ".tpl");
	}
	
	public static function getInstanceForInitializeState()
	{
	    return self::$instance;
	}
}
?>