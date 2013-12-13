<?php
/*Abstract Factory para templates
*instancia templatesEnginers dinamicamente
*/
class LoadTemplateEnginer
{
    protected $template, $collection, $ActionReference, $options, $className;
	
	public function __construct(array $options)
	{
	    $this->options = $options;
		
		$this->setAbstractRequestState($this->options['actionReference']);
		
		$this->templateSettings();
		
		$this->typeSettings();
		
		$this->collectionSettings();
	}
	
	protected function templateSettings()
	{
	    if(empty($this->options['template']))
		{
		    $this->template = $this->options['methodName'];
		}
		elseif(isset($this->options['template']))
		{
	        $this->template = $this->options['template'];
		}
		else
		{
		    $this->template = false;
		}
		
		return $this->template;
	}

	protected function collectionSettings()
	{
	    if(empty($this->options['collection']))
		{
		    $this->collection = null;
		}
		else
		{
		    $this->collection = $this->options['collection'];
		}
		
		return $this->collection;
	}
	
	protected function typeSettings()
	{
	    if(empty($this->options['type']))
		{
		    $this->className = ConfigTemplate::dafaultTemplate();
		    
		}
        else
		{
		    $this->className = $this->options['type']; 
		}
		
		return $this->className;
	}
	/*
	*se ao instanciar um objeto dessa classe e passar os parametros $object->type = 'simpleTemplateComponent'
	*a classe pai irá instanciar uma classe filha e ira enviar o template que será invocado
	*como  a coleção de objetos que vai para o mesmo
	*/
	public function load()
	{
	    new $this->className($this->options);
	}
	
	public function setAbstractRequestState($state)
	{
	    $this->ActionReference = $state;
	}
	
	public function getActionReference()
	{
	    return $this->ActionReference;
	}
	
}
?>
