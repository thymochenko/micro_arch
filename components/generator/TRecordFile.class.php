<?php

class TRecordFile{

    public $table;

	public $class;
	/* @table
	*  propriedade private que contém o nome da tabela a ser gerado os cruds
	*/
	public $tableLines = array();
	
	/* @tableLines
	*  propriedade private que contém um array com as linhas do banco de dados
	*/
	public function __construct($table, $class, $tableLines = array()){
	    $this->table = $table;
		$this->class = $class;
		$this->tableLines = $tableLines;
	}
	
	public function creatBody(){
	    return '<?php' . "\r\n". 
			
         'class ' . $this->class . ' extends Model{}'. "\r\n";
	}
	
	public function closeBody() {
		return "\r\n".
		'?>';
	}	
}
?>