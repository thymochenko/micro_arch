<?php
class DatabaseFacade implements Initializable {

    public function __construct($parameter) 
	{
        $this->parameter = $parameter;
    }

    public function initialize() 
	{
        $dbConnection = new DatabaseConnection;
        $dbConnection->setAttributes($this->parameter);
        $dbConnection->initialize();

        $conn = $dbConnection->getPdo();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
?>