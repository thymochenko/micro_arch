<?php
class ActionController {

    private static $inst;
    private $class, $method, $object;

    final function __construct() {
    }

    final function __clone()
	{
    }
	
    public static function getInstance(){
		if (!isset(self::$inst)):
            self::$inst = new self;
        endif;
        return self::$inst;
    }

    public function run()
	{
        if ($_GET):
            if (isset($this->get('stdClass')->class))
			{
                $this->class = Helper::upperPrimaryLetter(
					$this->get('stdClass')->class,
					'upper','Action'
				);
            }
			
            if (isset($this->get('stdClass')->method)) {
                $this->method = $this->get('stdClass')->method;
            }

            if (!class_exists($this->class)) {
                $red = new Redirect('error404.html');
                $red->display();
            }

            if (!method_exists($this->class, $this->method)) {
                $red = new Redirect('error404.html');
                $red->display();
            }

            $this->object = $this->class == get_class($this) ? $this : new $this->class;
          
			$this->afterFilterRegister($this->object, $this->method);
			
            $obj = new ReflectionMethod($this->object, $this->method);
			
			if($this->setAnnotation($obj))
			{
                call_user_func(array($this->object, $this->method));
            } else {
                $this->criticalRegion($this->object, $this->method);
            }
            if (function_exists($this->method)):
                call_user_func($this->method, $_GET);
            endif;

            $this->beforeFilterRegister($this->object, $this->method);
        endif;
    }

    public function post($class=null) {
        if (!$class):
            return HttpObjectInstance::getValues('post');
        else:
            return HttpObjectInstance::getValues('post', $class);
        endif;
    }

    public static function get($class=null) {
        if (!$class):
            return HttpObjectInstance::getValues('get');
        else:
            return HttpObjectInstance::getValues('get', $class);
        endif;
    }

    private function afterFilterRegister($class, $method) {
        new actionFilter('afterAction', array($class, $method));
    }

    private function beforeFilterRegister($class, $method) {
        new actionFilter('beforeAction', array($class, $method));
    }

    private function criticalRegion($object, $method) {
        try {
            Transaction::open();
            call_user_func(array($object, $method));
            Transaction::close();
        } catch (ActionException $e) {
            echo 'Exceção', $e->getMessage(), "\n";
        }
    }

    public function listering() {
        $request = new HearingPostRequest();
        $request->observerPost();
    }

    public function getMethodNameForActiveRequest() {
        return $this->method;
    }

    public function getClassNameForActiveRequest() {
        return $this->class;
    }

    public function setAnnotation(ReflectionMethod $obj) {
        $annotation = strstr($obj->getDocComment(), '@Transactional');
        return $annotation;
    }
	
	public function getObjectForRequest()
	{
	    return $this->object;
	}
}
?>
