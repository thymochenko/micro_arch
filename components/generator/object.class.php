<?php
class object {
    /* $table
	*  propriedade private que cont�m o nome da tabela a ser gerado os cruds
	*/
    public $table;
    /*$class
	*cont�m o nome da classe a ser criada.
	*/
	public $class;
	/*$tableLines
	* array de propriedades din�micas do objeto controller 
	*/
	public $template = array();
	
	public function __construct($table, $class, $template){
	    $this->table = $table;
		$this->class = $class;
		$this->template = $template;
	}
	
    public function creatBody() {
	     return '<?php' . "\r\n".
         'final class ' . $this->class . ' extends ' . $this->class . 'Action { ' . "\r\n";
	}
	
	public function closeBody() {
		return '}' . "\r\n".
		 '?>';
	}
	
	
	
    
}
	
	