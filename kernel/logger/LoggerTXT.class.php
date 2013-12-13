<?php
/*
*Classe TLoggerTXT
*implementa algor�timo de log em TXT
*/
class LoggerTXT extends Logger
{	
	/*
	*m�todo white()
	*escreve uma mensagem em um arquivo de log
	*@param $message = mensagem a ser escrita;
	*/
	public function write($message){
	    $time = date("Y-m-d H:i:s");
		//monta string
		$text = "$time :: {$message}\n";
		//adiciona ao final do arquivo
		$handler = fopen($this->filename, 'x');
		fwrite($handler, $text);
		fclose($handler);
	}
}
?>