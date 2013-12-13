<?php
/*
*Classe TLoggerXML
*implementa algorítimo de log em XML
*/
class LoggerXML extends TLogger{
	
	/*
	*método white()
	*escreve uma mensagem em um arquivo de log
	*@param $message = mensagem a ser escrita;
	*/
	public function write($message){
	    $time = date("Y-m-d H:i:s");
		//monta string
		$text = "<log>\n";
		$text.= "    <time>$time</time> : \n";
		$text.= "    <message>$message</message> <br>";
		$text.= "</log>\n";
		//adiciona ao final do arquivo
		$handler = fopen($this->filename, 'a');
		fwrite($handler, $text);
		fclose($handler);
	}
}
?>