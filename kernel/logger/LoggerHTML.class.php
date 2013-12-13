<?php
/*
*Classe TLoggerHTML
*implementa algorítimo de log em HTML
*/
class LoggerHTML extends Logger
{	
	/*
	*método white()
	*escreve uma mensagem em um arquivo de log
	*@param $message = mensagem a ser escrita;
	*/
	public function write($message){
	    $time = date("Y-m-d H:i:s");
		//monta string
		$text = "<p>\n";
		$text.= "    <b>$time</b> : \n";
		$text.= "    <i>$message</i> <br>";
		$text.= "</p>\n";
		//adiciona ao final do arquivo
		$handler = fopen($this->filename, 'a');
		fwrite($handler, $text);
		fclose($handler);
	}
}
?>