<?php
/*
*classe TFilter
*classe que provê uma interface para filtros de seleção.
*/
class Filter extends Expression
{
	private $variable;
	private $operator;
	private $value;
	static   $bindArray;
	private $bind_paran;
	static   $valueArray;
	/*
	   *método __construct
	   *instancia um novo filtro
	   *@param $variable
	   *@param $operator
	   *@param $valor = valor a ser transformado
	   */
	public function __construct($variable, $operator, $bind_paran, $value) {
		//armazena as propriedades
		$this->variable = $variable;
		$this->operator = $operator;
		$this->bind_paran = $bind_paran;
	
		$this->value = $this->transform($value);
		$valuestrRepres =(string) $this->value;
        $this->setBindValue($valuestrRepres);
        
		$binder=BindParameter::get();
		$binder->setSymbol($bind_paran);
		$binder->setParam($this->getBindValue());
	}
	/*
	   *método transform()
	   *recebe um valor e faz as modificações necessárias
	   *para ele ser interpretado pelo BD poder ser em determinados tipos de dados
	*/
	public function transform($value) {
		//caso seja um array
		if (is_array($value)) {
			//percorre os valores
			foreach ($value as $x) {
				//se for inteiro
				if (is_integer($x)) {
				    
					$foo[] = $x;
				} else
					if (is_string($x)) {
						//se for string, adiciona aspas
						$foo[] = "'{$x}'";
					}
			}
			//converte o array em string separada por ,
			
			$result = '(' . implode(',', $foo) . ')';
		}
		//caso seja uma string
		else
			if (is_string($value)) {
				//adiciona aspas
				$result = "'{$value}'";
			} else
				if (is_null($value)) {
					//armazena null
					$result = 'null';
				}
		//caso seja booleano
		else
			if (is_bool($value)) {
				//armazena true ou false
				$result = $value ? 'TRUE' : 'FALSE';
			} else {
				$result = $value;
			}
		//retorna o valor
		return $result;
	}
	/*
	   *método dump()
	   *retorna o filtro em forma de expressão.
	   */
	    public function dump()
	    {
		    //concatena a expressão
		    return "{$this->variable} {$this->operator} {$this->bind_paran}";
	    }

        public function setBindParam($paran){
            $this->bind_paran = $paran;
        }

        public function getBindParam(){
            return $this->bind_paran;
        }

        public function getBindValue(){
		
            return $this->value;
        }

        public function setBindValue($value){
            $this->value = $value;
        }
		
		public function getOperator(){
		    return $this->operator;
		}
}
?>