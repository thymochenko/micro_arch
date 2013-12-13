<?php

class StrategyXML implements FileDabaseConfigurationPlugIn {

    protected $xml, $dbName, $dir;

    private  function verifyPath() {
        if (file_exists("{$this->dir}/kernel/connection/metadata/{$this->dbName}.xml")):
            $this->resourceParseFile();
        else: return null;
        endif;

        return $this;
    }

    protected function resourceParseFile() {
        $this->xml = simplexml_load_file("{$this->dir}/kernel/connection/metadata/{$this->dbName}.xml");
    }

    public function dbName($db) {
        $this->dbName = $db;
        return $this;
    }

    public function metaDataDir($dir) {
        $this->dir = $dir;
        return $this;
    }

    public function createPDOInstance() {
        $this->verifyPath();
        $dbfacade = new DatabaseFacade($this->xml);
        $pdo_conn = $dbfacade->initialize();
        return $pdo_conn;
    }

}

?>
