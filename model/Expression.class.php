<?php

/*
*classe TExpression
*classe abstrata para gerenciar expressões
*/
abstract class Expression {
	//operadores lógicos
	const AND_OPERATOR = ' AND ';
	const OR_OPERATOR = ' OR ';
	static $count;
	//marca método dump como obrigatório
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