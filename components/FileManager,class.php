<?php
/*classe para manipulaзгo de imagens.
*envia a imagem para um diretуrio URL::BASE/image, cria uma miniatura.
*/
abstract class FileManager
{
    private $filekey;
	private $attributes=array();
	private $directory;
	private $namefile;
	private $tempfile;
	private static $dirbase;
	
	public function __construct($filekey, array $attributes, $directory)
	{
	    $this->setFilekey($filekey);
		$this->setAttributes($attributes);
		$this->setDirectory($directory);
		$this->setDirBase(ConfigPath::pathAppBase());
	}
	
	public function setAttributes()
	{
	    $this->attributes = $attributes;
	}
	
	public function getAttributes()
	{
	    return $this->attributes;
	}
	
	public function setFileKey()
	{
	    $this->filekey = $filekey;
	}
	
	public function getFileKey()
	{
	    
	    return $this->filekey;
	}
	
	public static function setDirBase($dirbase)
	{
	    self::$dirbase = $dirbase;
	}
	
	public static function getDirBase()
	{
	    return self::$dirbase;
	}

	protected function setNameFile($namefile)
	{
	    $this->namefile = $namefile;
	}
	
	protected function getNameFile()
	{
	    return $this->namefile;
	}
	
    public function processUpload()
	{
	    //verifica se й uma variбvel post
		if ($_FILES)
		{		
			$this->setNameFIle($_FILES["{$this->filekey}"]['name']);
			$this->tempfile = $_FILES["{$this->filekey}"]["tmp_name"];
			//move a imagem original para o diretуrio de imagem
			$move = move_uploaded_file($this->tempfile, $this->getDirectory());
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
	
	public function getDirectory()
	{
	    return self::$dirbase . "/media/{$this->directory}/{$this->getNamefile()}";
	}
	
	public function setDirectory($directory)
	{
	    $this->directory = $directory;
	}
	
	
	public function destroy(array $atributeList, $directory)
	{
	    $dir = self::$dirbase;
	    foreach($atributeList as $k=>$filename)
		{
		    $this->setNameFile($filename);
	        $this->setDirectory($directory);
			
	        if(file_exists($this->getDirectory())
			{
			    unlink($this->getDirectory());
			}
			else
			{
			    return true;
			}
	    }
	}
}
?>