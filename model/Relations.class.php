<?php
abstract class Relations
{
    
	protected $id,$property, $entity;
	
    public function __construct($id,$property,$entity)
	{
	    $this->id = $id;
		$this->property = $property;
		$this->entity = $entity;
	}
}
?>