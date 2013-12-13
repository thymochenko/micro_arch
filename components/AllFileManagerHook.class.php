<?php

class AllFileManagerHook extends FileManager
{
	public function __construct($filekey,$directory)
	{
	    parent::__construct($filekey, $attributes=array(null), $directory);
	}
	
	public function processUpload()
	{
	    //verifica se é uma variável post
		if($_FILES)
		{
			$this->setNameFIle($_FILES['videofile']['name']);	
			$this->tempfile = $_FILES['videofile']['tmp_name'];
			//move a imagem original para o diretório de imagem
			$move = move_uploaded_file($this->tempfile, self::$dirbase . '/media/files/' . $_FILES['videofile']['name']);
			
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