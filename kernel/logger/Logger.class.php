<?php

/*
 * Classe TLogger
 * Esta classe prov� uma interface abstrata para a defini��o de  algor�timos de log
 */

abstract class Logger {

    protected $filename;
    /*
     * m�todo __construct()
     * instancia um logger
     * @param $filename = path do arquivo;
     */

    public function __construct($filename) {
        $this->filename = $filename;
        //reseta o conteudo do arquivo
        file_put_contents($this->filename, '');
    }

    //define o m�todo write como obrigat�rio
    abstract function write($message);
}