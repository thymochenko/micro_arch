<?php
class ActionException extends ControllerFactoryException{
    
    public function __construct($exceptionMessage, $errorCode = 0)
	{
        parent::__construct($exceptionMessage, $errorCode);
    }
	
}

