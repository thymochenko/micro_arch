<?php
class TAbstractQueryException extends TModelException{
    
    public function __construct($exceptionMessage, $errorCode = 0) {
        parent::__construct($exceptionMessage, $errorCode);
    }
	
}

