<?php
class CoreException extends Exception{

	private $filename;

	/*__construct()
	*
	*/
    public function __construct($exceptionMessage, $errorCode = 0)
	{
        parent::__construct($exceptionMessage, $errorCode);
		//file name tem de ser setada
		//$this->filename = $filename;
    }

	public function setLogger($filename)
	{
	    $this->filename = $filename;
	}
	
	public function getLogger()
	{
	    return $this->filename;
	}
	
	public function log($message)
	{
	    $time = date("Y-m-d H:i:s");
		$time .="\r\n";
		//monta string
		$text = "\r\n $time :: {$message} \r\n";
		//adiciona ao final do arquivo
		$handler = fopen($this->filename, 'x+');
		fwrite($handler, $text);
		fclose($handler);
	}
	
	public function throwError()
	{
	    //caso ocorra erro, desfaz e fecha a transação.
		if(Transaction :: get()){
		    Transaction :: rollback();
		}
		echo " EXCEPTION " . __CLASS__;
		#echo "{Linha de erro} " . $this->getLine() . "<br>";
		#echo "TRACE -- ". print_r($this->getTrace()). "<br>";
		echo "{Mensagem de erro}" . $this->getMessage() . "<br>";
		//logger
		//message
		$message   =  " EXCEPTION " . __CLASS__ .' ';
		$message  .= $this->getMessage() . ' ';
		$message  .= ' linha de erro: ' .  $this->filename . ' ';

        
        #$this->log($message);
		Transaction::rollback();
	}
}

?>