<?php
class SqlInsert extends SqlInstruction
{
    private $columnValues;
	
    public function setRowData($column, $value)
	{
		//monta um array indexado pelo nome da coluna
		if(is_string($value))
		{
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
		elseif(isset($value))
		{
			return $this->columnValues[$column];
		}
		else
	    {
		    $this->columnValues[$column]="null";    
		}
	}
	
	public function setCriteria(TCriteria $criteria)
	{
	    throw new ModelException('um critério não pode ser setado em uma instrução de insert'. __CLASS__);
	}

	public function getInstruction()
	{
		//cria a cláusula de insert e atribui entidade {tabela}
		$this->sql = ' INSERT INTO ' . $this->entity . ' ';
		//abre colunas
		$this->sql .= '( ';
		$columns =  implode(" , ", array_keys($this->columnValues));
		//fecha clausula
		$values = implode(" , :", array_keys($this->columnValues));
             
		$this->sql .= $columns . ')';
		$this->sql .= " VALUES (:$values)";
		return $this->sql;
	}
}
?>
