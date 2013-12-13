<?php
class SqlSelect extends SqlInstruction
{
    private $columns;
	
	public function addColumn($column)
	{
		$this->columns[]=$column;
	}

	public function getInstruction()
	{
		//monta a instrução de select
		if($this->criteria->isDistinct())
		{
			$this->sql = 'SELECT DISTINCT '; 
		}
		elseif($this->criteria->isStraightJoin())
		{
			$this->sql = 'SELECT STRAIGHT_JOIN ';
		}
		else
		{
			$this->sql = 'SELECT ';
		}
		//monta a string com o nome das colunas
		$this->sql .= implode(',', $this->columns);
		//
		//adiciona na cláusula FROM o nome da tabela
		$this->sql .= ' FROM ' . $this->entity;
		//verifica se a propriedade acess esta verdadera(existe uma clausula join)
		if($this->criteria->acess == TRUE)
		{
		    $this->sql .= $this->criteria->getJoin();
		}
	
		//obtem a cláusula where do objeto criteria
		if ($this->criteria)
		{
			$expression = $this->criteria->dump();
           
			if ($expression)
			{
				$this->sql .= ' WHERE ' . $expression;
			}
			
			if(isset($this->criteria->inexpression) and $expression==null)
	        {
		        $this->sql .= $this->criteria->getIn();
		    }
			//obtem as propriedades do criterio
			$order=$this->criteria->getProperty('order');
			$limit=$this->criteria->getProperty('limit');
			$offset=$this->criteria->getProperty('offset');
			$group=$this->criteria->getProperty('group');

			//obtem a ordenação do select
			if($group)
			{
			    $this->sql .= ' GROUP BY ' . $group;
			}
			if($order)
			{
				$this->sql .= ' ORDER BY ' . $order;
			}
			if ($limit)
			{
				$this->sql .= ' LIMIT ' . $limit;
				return $this->sql;
			}
			if ($order)
			{
				$this->sql .= ' OFFSET ' . $offset;
			}
			
		}
		return $this->sql;
	}

}
?>
