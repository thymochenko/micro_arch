<?php
class ModelException extends CoreException {
    
    public function __construct($exceptionMessage, $errorCode = 0) {
        parent::__construct($exceptionMessage, $errorCode);
		parent::throwError();
    }	
}
?>

