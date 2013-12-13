<?php
/*
 * classe Trepository
 * esta classe provê métodos nescessários para manipulação de coleçõesde objetos
 */
class Repository
{
    private $class; //nome da classe manipulada pelo repositorio
    private static $cache;
    /* método __ construct()
     * instancia um repositorio de objetos
     * @param $class = classe dos objetos
     */
    private $results;

    public function __construct($class) {
        $this->class = $class;
    }

    /*
     * método load()
     * recuperar um conjunto de objetos (collection) da base de dados
     * através de um critério de seleção, e instanciá-los em memória
     * @param $criteria = objeto do tipo TCriteria
     * @param $column = array de colunas selecionadas
     * @param $cache_flife_time = inteiro com o tempo em segundos para uma consultas
     */

    function load(Criteria $criteria, $column=null, $config=null) {
		$sql = new SqlSelect;
		$entity = Helper::upperPrimaryLetter(
					$this->class,
					'lower','');
					
        $sql->setEntity(strtolower("{$entity}"));
        
		if(is_array($column)){
            foreach($column as $k => $coll):
			    $sql->addColumn($coll);
            endforeach;
        }
        elseif (is_string($column)) {
            $sql->addColumn($column);
        }
		else
		{
            $sql->addColumn('*');
        }
		
        $sql->setCriteria($criteria);
		
        $conn = Transaction::get();
		
		//echo $sql->getInstruction();
        
		$sth = $conn->prepare($sql->getInstruction());
        $binder=new BindParameter;
        $binder->setCriteria($criteria);
        $binder->setPdoStatement($sth);
        $binder->processCriteriaParameters();
            
            if (!$sth->execute())
			{
                throw new RepositoryException('Error execute Query');
                exit;
            }

            if (ConfigLogger::start()) {
                Transaction::setLogger(new LoggerHTML(ConfigLogger::_HTML() . rand(10, 10000) . '_load.html'));
                Transaction::log(' SQL Instruction - <br>method <b>' . __FUNCTION__ . ' </b><br>' . $sql->getInstruction());
            }
			
			if(!$config){
			    $cache_id=rand(10, 100000);
				$cache_life_time = 3;
			}
			else{
			    $cache_id=$config['cache_id'];
				$cache_life_time = $config['cache_life_time'];
			}
			
			$cache = new CacheService(
			    $cache_life_time,
			    $path=ConfigCache::cachePath(),
			    $cache_id,
		    	$entity=$sql->getEntity(),
			    $statment=$sth
			);
			
			//para o cach
			if($data = $cache->getData())
			{
			    if(is_null($data))
				{
					
				    new RepositoryException('No Results Found ');
					return false;
				}
				else
				{
				    $this->results = $data;
                    return $this->results;
				}
			}
			else
			{
			    //sem cache
			    $results = $cache->fetch()->returnObject();
			    
				if(isset($results))
				{
				    return $results;
				}
				else
				{
				    return false;
				}
			}
        }
    
    function destroy(Criteria $criteria) {
        //instancia uma instrução de delete
        $sql = new SqlDelete();
        $sql->setEntity($this->class);
        //atribui o criterio passado como parametro
        $sql->setCriteria($criteria);

        //obtem a transação ativa
        if ($conn = Transaction :: get()) {
            //execulta a consulta no banco de dados
            if (!$sth = $conn->prepare($sql->getInstruction()))
			{
                throw new RepositoryException('(Exception: transaction) :: Erro ao destruir Registros');
            }

            $binder=new BindParameter;
            $binder->setCriteria($criteria);
            $binder->setPdoStatement($sth);
            $binder->processCriteriaParameters();
            
            //execulta query
            if (!$sth->execute()) {
                throw new RepositoryException('Erro na query');
                exit;
            }
            //retorna valor;
            return $sth;
        } else {
            //se não tiver transação, retorna exception
            throw new RepositoryException('Exception: não há transação ativa');
        }
    }

    /* método count()
     * retorna a quantidade de objetos da base de dados
     * que satisfazem determinado criterio de seleção
     * @param $criteria = objeto do tipo criteria;
     */

    function count(Criteria $criteria) {
        $sql = new SqlSelect;
        $sql->setEntity("{$this->class}");

        $sql->addColumn('count(*)');
        //atribui o criterio passado como parametro
        $sql->setCriteria($criteria);

        //obtem a transação ativa
        if ($conn = Transaction :: get()) {
            //execulta a consulta no banco de dados
            $result = $conn->query($sql->getInstruction());
            if ($result) {
                $row = $result->fetch();
            }
            //retorna o resultado
            return $row[0];
        } else {
            //se não tiver transação, retorna exception
            throw new RepositoryException('Exception: não há transação ativa');
        }
    }
}

?>
