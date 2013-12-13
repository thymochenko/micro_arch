<?php
/*classe para manipulaзгo de imagens.
*envia a imagem para um diretуrio URL::BASE/image, cria uma miniatura.
*/
abstract class FileManager
{
    protected $filekey;
	protected $attributes=array();
	protected $directory;
	protected $namefile;
	protected $tempfile;
	protected static $dirbase;
	
	public function __construct($filekey, array $attributes=null, $directory=null)
	{
	    $this->setFilekey($filekey);
		if(isset($attributes))
		{
			$this->setAttributes($attributes);
		}
		$this->setDirBase(ConfigPath::pathAppBase());
		$this->setDirectory($directory);
	}
	
	public function setAttributes(array $attributes)
	{
	    $this->attributes = $attributes;
	}
	
	public function getAttributes()
	{
	    return $this->attributes;
	}
	
	public function setFileKey($filekey)
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
	
    public function processUpload($id=null)
	{
	    //verifica se й uma variбvel post
		if($_FILES)
		{
            if($id)
			{
			    $file = $id  . '_file_' . $_FILES["{$this->filekey}"]['name'];
				$this->setNameFIle($file);
			}
			else
			{
				$this->setNameFIle($_FILES["{$this->filekey}"]['name']);
			}
			
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
	    if(file_exists(self::$dirbase . "/media/{$directory}"))
		{
	        $this->directory = $directory;
		}
		else
		{
		     if(mkdir(self::$dirbase . "/media/{$directory}", 0777, true))
			 {
			     $this->directory = $directory;
			 }		 
		}
	}
	
	public function destroy(array $atributeList, $directory)
	{
	    $dir = self::$dirbase;
	    foreach($atributeList as $k=>$filename)
		{
		    $this->setNameFile($filename);
	        $this->setDirectory($directory);
			
	        if(file_exists($this->getDirectory()))
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