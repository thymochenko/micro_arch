<?php 
class XMLFinder{
    protected $file;
    public function __construct($file){
	    $this->file = $file;
	}
	
	public function find(){
	    $xml = simplexml_load_file($this->file);
		return $xml;
	}
}