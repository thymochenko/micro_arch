<?php

/**
 *
 * @author thymochenko
 */
interface FileDabaseConfigurationPlugIn  {
    public function dbName($dbName);
    public function metaDataDir($dir);
    public function createPDOInstance();
}
?>
