<?php
class oabpiaui
{
    private $parans=array(
	    'user'=>'root',
	    'pass'=>'',
	    'name'=>'oabpiaui',
	    'host'=>'localhost',
	    'type'=>'mysql'
	);
	
	public function getDatabaseParans()
	{
	    return $this->parans;
	}
}
?>