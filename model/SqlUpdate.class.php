<?php
class SqlUpdate extends SqlInstruction
{
    private $columnValues,$set;
	
    public function setRowData($column, $value)
	{
		//monta um array indexado pelo nome da coluna
		if (is_string($value))
		{
			//sanitiza string
			//atribui
			$this->columnValues[$column] = "'{$value}'";
		}
		else if(is_bool($value))
		{
			//caso seja booleano
			$this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
		} 
		elseif(is_float($value))
		{
		    $this->columnValues[$column] = (float)$value;
		}
		elseif(is_int($value))
		{
		    $this->columnValues[$column] = (int)$value;
		}
		else if(isset($value))
		{
			//caso seja outro tipo de dado
			return @$this->columnValues[$column];
		}
		else
	    {
		    $this->columnValues[$column]="null";    
		}
	}
	
	public function getInstruction() 
	{
		$this->sql = "UPDATE {$this->entity} ";
		//monta os pares [coluna] = [valor]
		if ($this->columnValues)
		{
			foreach($this->columnValues as $column => $values)
			{
				$this->set[] = "{$column} = :{$column} ";
			}
		}
		$this->sql .= ' SET ' . implode(', ', $this->set);
		//retorna a clausula WHERE do objeto $this->criteria
		if ($this->criteria) {
			$this->sql .= ' WHERE ' . $this->criteria->dump();
		}
		return $this->sql;
	}
}
?>