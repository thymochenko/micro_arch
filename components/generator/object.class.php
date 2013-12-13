<?php
class object {
    /* $table
	*  propriedade private que contém o nome da tabela a ser gerado os cruds
	*/
    public $table;
    /*$class
	*contém o nome da classe a ser criada.
	*/
	public $class;
	/*$tableLines
	* array de propriedades dinâmicas do objeto controller 
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
	
	