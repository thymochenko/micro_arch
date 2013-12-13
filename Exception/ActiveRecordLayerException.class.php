<?php
class ActiveRecordLayerException extends ModelException{
    
    public function __construct($exceptionMessage, $errorCode = 0) {
        parent::__construct($exceptionMessage, $errorCode);
    }
	
}

