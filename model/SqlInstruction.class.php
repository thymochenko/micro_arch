<?php
abstract class SqlInstruction
{
    protected $criteria;
    protected $sql;
    
	function __toString()
	{
		return "$this->sql";
	}
	
    public function setEntity($entity)
    {
        $this->entity=$entity;	
    }
	
	public function getEntity()
    {
        return $this->entity;	
    }
	
	public function setCriteria(Criteria $criteria)
	{
		$this->criteria=$criteria;
	}
	
	abstract function getInstruction();
}
?>
