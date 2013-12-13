<?php

abstract class ControllerFactory {
    /* @object = object
     * string contendo o objeto a ser inicializado nas consultadas e inserções do model
     */
    private $object;
    private static $objectStatic;
    static $class_state;
    static $actionInstance;
	public $Request;
    /* __construct
     * sempre que houver uma requisição Http o construtor é executado
     * @param $object = NULL
     * o o objeto é armazenado na propríedade do objeto controle, como um canguru que cuida de seus filhos.
     */
    public function __construct($object = null)
	{
	    
        if ($object):
            //trabalhando com objetos anônimos
            self::$class_state = new stdClass;
            //armazena o nome do objeto execultado em tempo de execução em um propriedade estática.
            self::$class_state->objectContextModel = $object;
            //TController recebe o nome do objeto filho que está sendo execultada
            $this->object = $object;
        endif;

        $this->object = substr(get_class($this), 0, -6);
    }

    /*
     * @deprecated
     */

    public static function getActionController()
	{
        self::$actionInstance = ActionController::getInstance();
        return self::$actionInstance;
		
    }

    public static function request()
	{
        self::$actionInstance = ActionController::getInstance();
        return self::$actionInstance;
    }
	/*
	public function request()
	{
	    $this->Request = ActionController::getInstance();
		return $this->Request;
	}
	*/

    public function controller() {
        $class = get_class($this);
        #$class=substr($class, 0, 8);
        $object = new $class(substr($class, 0, -6));
        return $object;
    }

    public function store($object)
	{
        try {
            //cria novo objeto noticia record
            $object = new $object;
	          
			$obStrig = get_class($object);
            $object = self::request()->post($obStrig);
  
            //string global que vem do form que serve para decisao de qual metodo executar. não vai pra query
            unset($object->insert);
            if ($object->store())
			{
                Message::_get('Info', "<h2> Cadastro realizada com sucesso</h2>");
            }
			else
			{
                throw new ControllerFactoryException('erro ao inserir Controller.class');
            }
			
        } catch (ControllerFactoryException $e) {
            //exibe uma mensagem de erro
            echo $e->getMessage();
            Transaction :: rollback();
            exit ();
        }
    }

    public function update($object) {
        try {

            //cria novo objeto noticia record
            $object = new $object;
            $obStrig = get_class($object);
            $object = $this->request()->post($obStrig);
            //string global que vem do form que serve para decisao de qual metodo executar. não vai pra query
            unset($object->update);
            $object->update();
            Message::_get('Info', "<h2>Update realizada com sucesso</h2>");
        } catch (ControllerFactoryException $e) {
            echo $e->getMessage();
            Transaction :: rollback();
            exit ();
        }
    }

    public function destroy($object) {
        try {
            //verifica se é uma variável post
            if ($_GET['id']) {
                $object = new $object;
                $obStrig = get_class($object);
                $object = self::request()->post($obStrig);
                $object->id = $_GET['id'];
                //string global que vem do form que serve para decisao de qual metodo executar. não vai pra query
                unset($object->delete);
                $object->destroy();
                Message::_get('Info', "<h2>Destroy realizada com sucesso</h2>");
            } else {
                throw new ControllerFactoryException(' não há uma transação ativa para o método destroy()');
            }
        } catch (ControllerFactoryException $e) {
            echo $e->getMessage();
            Transaction::rollback();
            exit ();
        }
    }

    protected function render(array $options) {
        $options['actionReference'] = $this->object;
        $options['methodName'] = self::getActionController()->getMethodNameForActiveRequest();
        $renderer = new LoadTemplateEnginer($options);
        $renderer->load();
    }
	
	#deprecated
    public function staticRender(array $param) {
        $smarty = singleSmarty::createInstance();
        $smarty->setInitializers($param['view_dirname']);
        //pega path de compilação
        $compiler = singleSmarty::tplCompiler($param['view_dirname']);
        //renderiza o objeto do model para o template smarty
        $smarty->assign($param['view_dirname'], null);
        //dispacha saida.
        $smarty->display($compiler . "/" . $param['tpl_name'] . ".{$param['extension']}");
		//o renderizador static encerra o fluxo da app
		
    }
	
	public function _staticRender($dirname,$templateName)
	{
		$path = ConfigPath::pathAppBase();
        $lz_tpl = $path . '/protected/views/views.' . $dirname . '/' .$templateName . '.html';
        $tpl = new Template($lz_tpl);
        $tpl->set($dirname, array(null));

        echo $tpl->fetch($lz_tpl);
	}
	
    public function template() {
        $smarty = singleSmarty::createInstance();
        return $smarty;
    }

    /*
     * pega o estado da requisição de domínio.
     * ou seja, pega de forma estática o objeto que estende LZAction dinamicamente.
     * a classe pai descobre se a classe filha é invocada, ao descobrir, armazena o nome do objeto
     * em uma propriedade estática
     */

    public static function getStateForRequestDomain() {
        return self::$objectStatic;
    }

    public function initializeIndex($templateType=null) {
        if ($templateType):
            $this->render(array(
                'template' => 'index',
                'collection' => null,
                'type' => $templateType)
				);
        endif;

        $this->render(array(
            'template' => 'index',
            'collection' => null,
            'type' => null));
    }
	
    /**
	*@deprecated
	*/
    public function edit($template=null) {
                $object = Model::object($this)
                        ->finder()->findById((int) self::request()
                                ->get('stdClass')
                        ->id
        );
        
		if(empty($template)){
            $template = __FUNCTION__;
        }
		
        $this->render(array(
            'collection' => $object, 'template'=>$template));
    }
    
    public function sendActionById($template=null)
	{
                $object = Model::object($this)
                        ->finder()->findById((int) self::request()
                                ->get('stdClass')
                        ->id
        );
        
		if(empty($template)){
            $template = __FUNCTION__;
        }
		
        $this->render(array(
            'collection' => $object, 'template'=>$template));
    }
	
    /**
	*@deprecated
	*/
    public function storeview($template=null) {
	    if(isset($template)){
            $this->render(array('template'=>$template));
		}
		else{
		    $this->render(array(null));
		}
    }

    public function index($template=null) {
        $object = Model::object($this)->finder()->findAll();
		
        $class = substr(get_class($this), 0, -6);
		
		if(empty($template)){
            $template = 'getAll' . $class;
        }
		
		$this->render(array(
            'collection' => $object,
            'template' => $template));
    }
	
    /**
	*@deprecated
	*/
    public function deleteview($template=null) {
        $object = Model::object($this)
                        ->finder()->findById((int) self::request()
                                ->get('stdClass')
                        ->id
        );
        
		if(empty($template)){
            $template = __FUNCTION__;
        }
		
        $this->render(array(
            'collection' => $object, 'template'=>$template));
    }

    public function destroySelectedElements() {
		if (self::request()->post('stdClass')->method == 'destroy') {
            foreach (self::request()->post('stdClass') as $k => $post) {
                $post = (int) $post;
                if ($post != 0) {
                    $ids[] = $post;
                }
            }
            
            $criteria = new Criteria;
            $criteria->getCollection(array('id' => $ids));
            $repository = new Repository(self::request()->get('stdClass')->class);
            $repository->destroy($criteria);

            Message::_get('Info', 'coleção excluida com sucesso');
        }
    }
	
	public function redirect(array $params)
	{
	    if(isset($params['class']) and isset($params['method']) and empty($params['type'])){
			echo '<script language= "JavaScript">'. '
                location.href="index.php?class=' . $params['class'] . '&method=' . $params['method'] .'";
                </script>';
				return true;
		}
		if($params['type'] == 'query')
		{
		    echo '<script language= "JavaScript">' . '
                location.href="index.php?class=' . $params['class'] . '&method=' . $params['method'] .'&' . http_build_query($params['query'])  . '";
                </script>';
		}
		elseif(isset($params['type']['timeRedirect']))
		{
		    echo '<script language= "JavaScript">'. '
			    setTimeout(function()
				{
                location.href="index.php?class=' . $params['class'] . '&method=' . $params['method'] .'";
                 },'. $params['type']['timeRedirect']. ');</script>';    
		}
	}
}
?>