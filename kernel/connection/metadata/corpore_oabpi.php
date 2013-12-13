<?php
class corpore_oabpi
{
    private $parans=array(
	    'user'=>'root',
	    'pass'=>'',
	    'name'=>'corpore_oabpi',
	    'host'=>'localhost',
	    'type'=>'mysql'
	);
	
	public function getDatabaseParans()
	{
	    return $this->parans;
	}
}
?>