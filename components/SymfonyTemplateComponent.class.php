<?php
include_once 'symfonyTe/lib/sfTemplateAutoloader.php';

class SymfonyTemplateComponent extends LZLoadTemplateEnginer implements LZPlugInTemplateInterface
{
    public function __construct($template, $collection)
	{
	    parent::__construct($template, $collection);
	    $this->initEnginer();
	}
	
	
	public function initEnginer()
	{
	    //atribui os objetos para um template smarty
		$path = LzConfigPath::pathAppBase();;
		
		$pathToFileSystem=$path . '/protected/views/views.'. ControllerFactory::$objectStatic . '/'. '%name%' . '.php';
		
	    sfTemplateAutoloader::register();
		
		$loader=new sfTemplateLoaderFilesystem($pathToFileSystem);
        $engine=new sfTemplateEngine($loader);
		
		for($i=0; $i < count($this->collection); $i++):
            echo $engine->render($this->template, $this->collection[$i]->data);
		endfor;
	}
	
	public static function init()
	{
	    sfTemplateAutoloader::register();
	}
}