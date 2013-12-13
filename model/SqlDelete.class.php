<?php
class SqlDelete extends SqlInstruction
{
	public function getInstruction()
	{
		//monta a string de deleção
		$this->sql = "DELETE FROM $this->entity";
		//retorna a clausula where do objeto $this->Criteria
		if ($this->criteria)
		{
			$expression = $this->criteria->dump();
			if ($expression)
			{
				$this->sql .= ' WHERE ' . $expression;
			}
			elseif($this->criteria->inexpression){
			    $this->sql .= " WHERE {$this->criteria->key} in " . $this->criteria->inexpression;  
			}
		}
		return $this->sql;
	}
}
?>
