<?php

/*
*classe TExpression
*classe abstrata para gerenciar express�es
*/
abstract class Expression {
	//operadores l�gicos
	const AND_OPERATOR = ' AND ';
	const OR_OPERATOR = ' OR ';
	static $count;
	//marca m�todo dump como obrigat�rio
	abstract public function dump();
	
	public static function _and(){
	    $result=array('and'=>'and'.self::$count++);
		return $result['and'];
	}
	
	public static function _or(){
		$result=array('or'=>'_or'.self::$count++);
		return $result['or'];
	}
}
?>