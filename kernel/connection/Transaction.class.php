<?php

final class Transaction {
    /*
     * classe transação
     * esta classe prove métodos para manipular transações
     */

    private static $conn;

    private static $logger; //objeto de log

    /*
     * método contrutor()
     * está declarado como private para impedir que se criem novas instÂncias
     */

    private function __construct() {
        
    }

    /*
     * método open()
     * abre uma transação e uma conexão com o BD
     *  @param $databese = nome do banco de dados
     * */

    public static function open($database=null) {  //nome do banco de dados que vc deseja.
		if ($database)
		{
            //abre uma transação
            self::$conn = ConnectionFactory::open($database);
            //inicia a transação
            self::$conn->beginTransaction();
            return true;
        }
        elseif(empty(self::$conn) or is_null($database)) {
            //se um database for especificado
            self::$conn = ConnectionFactory::open(ConfigDatabase::database());
            //inicia a transação
            self::$conn->beginTransaction();
        }
    }

    /*
     * método get()
     * retorna a conexão ativa da transação
     */

    public static function get(){
        //retorna a conexão ativa
        return self::$conn;
    }

    public static function rollback() {
        if (self::$conn) {
            //desfaz as operações realizadas durante a transação
            self::$conn->rollback();
            self::$conn = null;
        }
    }

    /*
     * método close()
     * aplica as operações realizadas e fecha a transação
     */

    public static function close() {
        if (self::$conn) {
            //aplica as operações realizas
            //durante a transação.
            self::$conn->commit();
            self::$conn = NULL;
        }
    }

    /*
     * método setLogger()
     * define qual estratégia de log será usada
     */

    public static function setLogger(Logger $logger) {
        //pega o objeto $logger, e atribui ele a propriedade estatica self::$logger, armazenado-o na memória
        self::$logger = $logger;
    }

    /*
     * método Logg()
     * armazena uma mensagem no arquivo de log
     * baseada na estratégia de ($logger) atual;
     */

    public static function log($message) {
        //verifica se existe um objeto logger na memória
        if (self::$logger) {
            self::$logger->write($message);
        }
    }

}

?>
