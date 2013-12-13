<?php
class actionFilter
{
    private
	/*@param $typeAction (string)
	*tipo da ação (pode ser um filtro before(após) ou after(antes)  da ação
	*/
	$typeAction,
	
	/*@param =$obObserver (array)
	*$this->obObserver[0] = objeto da action correspondente
	*$this->obObserver[1]  = ação do objeto correspondente.
	*/
	$obObserver=array(),
	
    /*@param $properties = (array)
	*armazena as propriedades do objeto que contém a ação invocada
	*/
	$properties;
	
	/*usando
	* cria-se propriedades públicas dentro das meta-actions {objetos com posts, comments etc...}
	*da forma como segue a seguir
        public $be_filter=array('beforeFilter'=>array
	    ('callback'=>'getCountPosts',
	    'self'=>'index')
	);
	
	public $af_filter=array('afterFilter'=>
	    array
	        ('callback'=>'countPosts',
	        'self'=>'index')
	    )
	;
	/*
        public $be_filter=array('beforeFilter'=>array
	    ('callback'=>'getCountPosts',
	    'self'=>'index')
	);
	*/
	/*
	*callback= método a ser execultado
	*self=método que ira receber a ação do filtro
	*após criar as propriedades, crie uma classe dessa forma dentro do diretório filters dentro do diretório de controllers
	/*
	*<?php
        *class postsFilter extends postsAction
        *{
        /*
	*@after filter
	
    *public function countPosts()
	{
	    echo 'ola mundo filtro anterior a renderização da action';
	}
	/*
	*@before filter
	
	public function getCountPosts()
	{
	    echo 'ola mundo filtro após a renderização da action';
	}
       }
	*/
	
    public function __construct($typeAction,array $obObserver )
	{	
	    $this->typeAction=$typeAction;
		//classe e método que está sendo invocado
		$this->obObserver=$obObserver;
		switch($this->typeAction):
		    case 'afterAction':
			    $this->afterSend();
			break;
			case 'beforeAction':
			    $this->beforeSend();
			break;
			default:
			    return true;
			break;
		endswitch;
	}
	
	protected function afterSend()
	{
		#var_dump($this->obObserver[0]);
		$this->properties=get_class_vars(get_class($this->obObserver[0]));
		
		if($this->properties==NULL):return true;endif;
		foreach($this->properties as $k=> $prop)
		{
			if(is_array($prop))
			{
				foreach($prop as $filters=>$filter)
				{
					if($filters == 'afterFilter')
					{
						$class=get_class($this->obObserver[0]);
                                                
						$filterClass="{$class}Filter";
						if(class_exists($filterClass) and $_GET['method'] == $filter['self'])
						{
							$actionfilter=new $filterClass;
							$actionfilter->{$filter['callback']}();
						}
					}
				}
			}
		}
	}
	
	protected function beforeSend()
	{
		#var_dump($this->obObserver[0]);
		$this->properties=get_class_vars(@get_class($this->obObserver[0]));
		if($this->properties==NULL):return TRUE;endif;

		foreach($this->properties as $k=> $prop)
		{
			if(is_array($prop))
			{
				foreach($prop as $filters=>$filter)
				{
					if($filters == 'beforeFilter')
					{
					        //nome do objeto em requisição
						$class=get_class($this->obObserver[0]);
						$class = substr($class,0,-6);
                                                //cria a string que será a classe contendo os filtros de actions para o dominio
                                                $filterClass="{$class}Filter";

						if(class_exists($filterClass) AND $filter['callback'] != null)
						{
							$actionfilter=new $filterClass;
							$actionfilter->{$filter['callback']}();
                                                        return true;
						}
                                                if(isset($filter['listMethods'])){
                                                if(isset($filter['listMethods']) and !empty($filter['self'])){
                                                    foreach($filter['listMethods'] as $methods){
                                                        $actionfilter=new $filterClass;
							$actionfilter->{$methods}();
                                                    }
                                                }
					}
				}
			}
		}
	}
        }
}
