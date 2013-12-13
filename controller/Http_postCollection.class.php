<?php
class Http_postCollection implements HttpReturnable
{
	public function get($class=null)
	{
	    if($class==null):		    
		    foreach($_POST as $key => $value):
			    //atribui ao objeto as chaves e os valores do array e aplica filtro.
				$_POST[$key]=strip_tags(htmlspecialchars(addslashes($value)));
		    endforeach;
			return $_POST;
		endif;
		
		$obj=new $class;
		unset($_POST['insert']) ; unset($_POST['update']) ; unset($_POST['delete']);
		foreach($_POST as $key => $value):
			//atribui ao objeto as chaves e os valores do array e aplica filtro.
			$obj->$key=strip_tags(htmlspecialchars(addslashes($value)));
		endforeach;
		//atribui o objeto contendo as variáveis post
		return $obj;
	}
}
?>
