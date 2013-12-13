<?php
class DatabaseConnection implements Initializable
{
    protected $pdo;
	
	private $user, $pass, $name, $host, $type;
	
	public function initialize()
	{
	        switch ($this->type) 
		    {
			    case 'sqlite' :
				    $this->setPdo(new PDO("sqlite:{$this->name}"));
			    break;
			    case 'mysql' :
				    $this->setPdo(new PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass));
			    break;
			    case 'pgsql' :
				    $this->setPdo(new PDO("pgsql:dbname={$this->name};user={$this->user};password={$this->pass};host={$this->host}"));
			    break;
		    }
	}
	
	public function setPdo($conn)
	{
	    $this->pdo = $conn;
	}
	
	public function getPdo()
	{
	    return $this->pdo;
	}
	
	public function setAttributes($attribute)
	{
	    if(is_object($attribute))
		{
	        $this->user = $attribute->user;
		    $this->pass = $attribute->pass;
		    $this->name = $attribute->name;
		    $this->host = $attribute->host;
		    $this->type = $attribute->type;
		}
		elseif(is_array($attribute))
		{
		    $this->user = $attribute['user'];
		    $this->pass = $attribute['pass'];
		    $this->name = $attribute['name'];
		    $this->host = $attribute['host'];
		    $this->type = $attribute['type'];
		}
	}
}
?>
