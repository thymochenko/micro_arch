<?php
/*
*
*
	public function findAllPagesForDoctrine()
	{
	    //inicializa o pseudo-objeto Doctrine
	    __Doctrine__::initialize();
		
		$inst=Doctrine_Manager::getInstance();
		
		if($conn=TTransaction::get()):
		    $conn=Doctrine_Manager::connection($conn);
	    else:  throw new TRecordException
		    ('n�o h� uma transa��o ativa para a execul��o do m�todo');
		endif;
		//query, prepare, fetchAll, results...
		$stmt = $conn->prepare('SELECT * FROM pages');
        $stmt->execute();
        $results = $stmt->fetchAll();
		//return statment result
               return $results;
	} 
*
*/
	
class __Doctrine__ extends LZModelComponent
{
    public static function initialize()
	{
	    require_once('C:\www\doctrine_test\lib\Doctrine.php');
        spl_autoload_register(array('Doctrine', 'autoload'));
	}
}


?>