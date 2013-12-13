<?php

final class Transaction {
    /*
     * classe transa��o
     * esta classe prove m�todos para manipular transa��es
     */

    private static $conn;

    private static $logger; //objeto de log

    /*
     * m�todo contrutor()
     * est� declarado como private para impedir que se criem novas inst�ncias
     */

    private function __construct() {
        
    }

    /*
     * m�todo open()
     * abre uma transa��o e uma conex�o com o BD
     *  @param $databese = nome do banco de dados
     * */

    public static function open($database=null) {  //nome do banco de dados que vc deseja.
		if ($database)
		{
            //abre uma transa��o
            self::$conn = ConnectionFactory::open($database);
            //inicia a transa��o
            self::$conn->beginTransaction();
            return true;
        }
        elseif(empty(self::$conn) or is_null($database)) {
            //se um database for especificado
            self::$conn = ConnectionFactory::open(ConfigDatabase::database());
            //inicia a transa��o
            self::$conn->beginTransaction();
        }
    }

    /*
     * m�todo get()
     * retorna a conex�o ativa da transa��o
     */

    public static function get(){
        //retorna a conex�o ativa
        return self::$conn;
    }

    public static function rollback() {
        if (self::$conn) {
            //desfaz as opera��es realizadas durante a transa��o
            self::$conn->rollback();
            self::$conn = null;
        }
    }

    /*
     * m�todo close()
     * aplica as opera��es realizadas e fecha a transa��o
     */

    public static function close() {
        if (self::$conn) {
            //aplica as opera��es realizas
            //durante a transa��o.
            self::$conn->commit();
            self::$conn = NULL;
        }
    }

    /*
     * m�todo setLogger()
     * define qual estrat�gia de log ser� usada
     */

    public static function setLogger(Logger $logger) {
        //pega o objeto $logger, e atribui ele a propriedade estatica self::$logger, armazenado-o na mem�ria
        self::$logger = $logger;
    }

    /*
     * m�todo Logg()
     * armazena uma mensagem no arquivo de log
     * baseada na estrat�gia de ($logger) atual;
     */

    public static function log($message) {
        //verifica se existe um objeto logger na mem�ria
        if (self::$logger) {
            self::$logger->write($message);
        }
    }

}

?>
