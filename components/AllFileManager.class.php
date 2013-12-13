<?php

class AllFileManager extends FileManager
{
	public function __construct($filekey,$directory)
	{
	    parent::__construct($filekey, $attributes=array(null), $directory);
	}
	
	public function processUpload($i)
	{
	    //verifica se é uma variável post
		if($_FILES)
		{
			$this->setNameFIle($_FILES['files']['name'][$i]);	
			$this->tempfile = $_FILES['files']['tmp_name'][$i];
			//move a imagem original para o diretório de imagem
			
			$move = move_uploaded_file($this->tempfile, self::$dirbase . '/media/files/' . Arquivos::satinizeFile($_FILES['files']['name'][$i]));
			
			if($move)
			{
			    return true;
			}
			else
			{
			    throw new Exception("Error Upload File");
			}
	     }
	}
}

?>