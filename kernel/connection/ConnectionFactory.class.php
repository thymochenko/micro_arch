<?php
class ConnectionFactory{
    /**
     * método open()
     * recebe o nome do banco de dados e instancia o objeto PDO correpondente
     */
    public static function open($name) 
    {
        $dir = ConfigPath::AppCore();

        $config = new StrategyConfiguration($plug_in_prefix = 'Strategy');

        $conn = $config->getTypeConfFiles(array('XML', 'PHP', 'JSON', 'YML','INI'))
                        ->dbName($name)
                        ->metaDataDir($dir)
                        ->createPDOInstance();

        if ($conn instanceof PDO)
            return $conn;

        throw new CoreException("<h2>Erro ao conectar com o banco</h2>");
    }
}
?>