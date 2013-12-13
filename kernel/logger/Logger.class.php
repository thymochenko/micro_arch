<?php

/*
 * Classe TLogger
 * Esta classe provê uma interface abstrata para a definição de  algorítimos de log
 */

abstract class Logger {

    protected $filename;
    /*
     * método __construct()
     * instancia um logger
     * @param $filename = path do arquivo;
     */

    public function __construct($filename) {
        $this->filename = $filename;
        //reseta o conteudo do arquivo
        file_put_contents($this->filename, '');
    }

    //define o método write como obrigatório
    abstract function write($message);
}