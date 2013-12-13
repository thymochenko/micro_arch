<?php
class Http_getCollection implements HttpReturnable
{
	public function get($class=null)
	{
	    if($class==null):		    
		    foreach($_GET as $key => $value):
			    //atribui ao objeto as chaves e os valores do array e aplica filtro.
			    $_GET[$key]=strip_tags(htmlspecialchars(addslashes($value)));
		    endforeach;
			return $_GET;
		endif;
		
		$obj=new $class;
		foreach($_GET as $key => $value):
			//atribui ao objeto as chaves e os valores do array e aplica filtro.
			$obj->$key=strip_tags(htmlspecialchars(addslashes($value)));
		endforeach;
		//atribui o objeto contendo as variáveis post
		return $obj;
	}
}
?>
