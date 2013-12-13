<?php
class ImageManager extends FileManager
{    
	public function __construct($filekey, $attributes, $directory)
	{
	    parent::__construct($filekey, $attributes, $directory);
	}
	
	public function processUpload()
	{
	    parent::processUpload();
	    return $this;	
	}
	
	public function createImage($width,$heigth,$newfilename)
	{
		$img = new SimpleImage();
		$img->load(self::$dirbase . "/media/{$this->directory}/{$this->getNamefile()}")
		->resize($width,$heigth)
		->save(self::$dirbase . "/media/{$this->directory}/{$newfilename}");
		return $this;
	}
	
}
?>