<?php
/*
*classe TCriteria
*classe que provê definição de critérios
*/
class Criteria extends Expression
{
    public  $expressions; // armazena lista de expreções.
	private $operators;   //armazena lista de operadores.
	private $properties;  //propriedades do critério.
	public  $inexpression;
	public  $acess=false;
	private $clausule;
	public  $key;
	private $join_closule;
	private $distinct;
	private $straightJoin;
	CONST ON=true;
	
	/*
        *método add()
	*adiciona uma expressão ao critério	
        *@param $expression = expressão (objeto TExpression)
	*@param $operator    = operador lógico de comparação
        */
	public function isDistinct()
	{
	    if($this->distinct == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function selectDistinct()
	{
		$this->distinct = true;
	}
	
	public function straightJoin()
	{
		$this->straightJoin = true;
	}
	
	public function isStraightJoin()
	{
		if($this->straightJoin == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function add(Expression $expression, $operator = self::AND_OPERATOR)
	{
	    if(empty($this->expressions))
		{
		    unset($operator);
		}
		//agrega o resultado das expreções a lista de expreções
		$this->expressions[] = $expression;
		@$this->operators[] = $operator; 
	}
	
	/*
        *método dump()
	*retorna a expressão final
        */
	public function dump()
	{
	    if(is_array($this->expressions))
		{
		    foreach($this->expressions as $i=> $expression)
			{
			    $operator = $this->operators[$i];
				//concatena o operador com a respectiva expressão
				@$result .= $operator . $expression->dump() . '';
			}
			$result = trim($result);
			return "({$result})";
		}
        elseif($this->expressions == null){
		//echo "expressões não carregadas";
		return FALSE;
		}		
	}
	/*
        *método setProperty()
	*define o valor de uma propriedade
        */
	public function setProperty($property, $value)
	{
	    $this->properties[$property] = $value;		
	}
	/*
    *método getProperty()
	*retorna o valor de uma propriedade
    */
	public function getProperty($property)
	{
	    return @$this->properties[$property];
	}
	
	public function addJoin()
	{
	    $this->acess = true;
		
		$num_args = func_num_args();

		for($i=0;$i<$num_args;$i++):
		    $this->closule[]=func_get_arg($i);
		endfor;
	} 
	
	public function getCollection(array $inexpression){	
		$in=array_keys($inexpression);
		$this->key=$in[0];
		foreach($inexpression as $ex):
		    $expre=implode(',',$ex);
		endforeach;
	    	
		$this->inexpression="($expre)";
	}
	
	public function getIn()
	{
	  
	    return ' WHERE ' .$this->key . ' in '. $this->inexpression;
	}
	
	public function getJoin()
	{
	    $closule = array_values($this->closule);
	   
		foreach($closule as $k =>$closule_expr)
		{
		    foreach($closule_expr as $k=>$keys): $entity = $k; endforeach;

		    foreach($closule_expr as $expr)
			{
			    $expr_str = $expr;
			}
			
			$this->join_closule .= ' LEFT JOIN ' . $entity . ' ON ' . $expr_str;
		}
		
		return $this->join_closule;
	}

        public function getExpressions()
        {
            return $this->expressions;
        }
        
}
?>