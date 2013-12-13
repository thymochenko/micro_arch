<?php

class StrategyINI implements FileDabaseConfigurationPlugIn {

    protected $dbName, $dir, $ini;

    private function verifyPath() {
        if (file_exists("{$this->dir}/kernel/connection/metadata/{$this->dbName}.ini")):
            $this->resourceParseFile();
        else: return null;
        endif;

        return $this;
    }

    protected function resourceParseFile() {
        $this->ini = parse_ini_file("{$this->dir}/kernel/connection/metadata/{$this->dbName}.ini");
    }

    public function dbName($db) {
        $this->dbName = $db;
        return $this;
    }

    public function metaDataDir($dir) {
        $this->dir = $dir;
        return $this;
    }

    public function createPDOInstance() 
	{
        $this->verifyPath();
        $dbfacade = new DatabaseFacade($this->ini);
        $pdo_conn = $dbfacade->initialize();
        return $pdo_conn;
    }

}

?>
