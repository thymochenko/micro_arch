<?php
class StrategyPHP implements FileDabaseConfigurationPlugIn
{
    protected $php, $db, $dir;
    
	public function verifyPath()
	{
        if (file_exists("{$this->dir}/kernel/connection/metadata/{$this->db}.php")):
            $this->resourceParseFile();
        else:
    		return null;
        endif;
        return $this;
	}
	
	public function resourceParseFile()
	{
	    include "{$this->dir}/kernel/connection/metadata/{$this->db}.php";
		$db = new $this->db;
		$this->php = $db->getDatabaseParans();
	}
	
	public function dbName($db)
	{
	    $this->db = $db;
		return $this;
	}
	
	public function metaDataDir($dir)
	{
	    $this->dir = $dir;
		return $this;
	}
	
	public function createPDOInstance() 
	{
        $this->verifyPath();
        $dbfacade = new DatabaseFacade($this->php);
        $pdo_conn = $dbfacade->initialize();
        return $pdo_conn;
    }
}
?>