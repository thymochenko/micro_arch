<?php
class Finder
{
    protected $entity;
    private static $cache;
    static $count;

    public function __construct($entity)
	{
        $this->entity = $entity;
    }

    public function find(array $properties, array $config=null) {
        	
        $c = new Criteria;
       
	    if($properties['entity'][0] != null)
	    {
           $repository = new Repository($properties['entity'][0]);
        }
		else
		{
            $repository = new Repository($this->entity);
        }
        if(isset($properties['where']))
		{
            $c->add(new Filter($properties['where'][0],
			$properties['where'][1], $properties['where'][2], $properties['where'][3]));
			
        }
        foreach($properties as $k => $property)
		{
            $str = strpos($k, 'and');
            if ($str === false)
			{
                true;
            }
			else
			{
                $c->add(new Filter($property[0], $property[1], $property[2], $property[3]));	
            }
            $str2 = strpos($k, '_or');
            if($str2 === false)
			{
                true;
            }
			else
			{
                $c->add(new Filter($property[0], $property[1], $property[2], $property[3]), Expression::OR_OPERATOR);
            }
        }
        if(isset($c->expressions))
		{
            foreach ($c->expressions as $k => $filter)
			{
                if ($filter->getBindValue() == 'null')
				{
                    unset($c->expressions[$k]);
                }
            }
        }

        if (isset($properties['order']))
		{
            $key = array_keys($properties['order']);
            $value = array_values($properties['order']);
        }

        if(isset($key) and isset($value))
		{
            $c->setProperty('limit', $properties['limit'][0]);
            $c->setProperty('order', $key[0] . ' ' . $value[0]);
        }
		 
        if (!is_null($properties['attributes'][0]) and !is_null($config))
		{
		
            $results = $this->verifyResults($repository->load($c, array_values($properties['attributes']), $config));
			return $results;
        }
		elseif(!is_null($properties['attributes'][0]))
		{
            $results = $this->verifyResults($repository->load($c, array_values($properties['attributes'])));
       
			return $results;
        }
        if(isset($config))
		{
		    
            $results = $this->verifyResults($repository->load($c, $config));
            return $results;
        }
		else
		{
		    $results = $this->verifyResults($repository->load($c));
            return $results;
        }

        return $results;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $expression = array(
                'entity' => array(null),
                'attributes' => array(null),
                'where' => array('id', '=', ':id', $id)
            );
            return $this->find($expression);
        } else {
            throw new ModelException('parametro Id não é um inteiro');
        }
    }

    public function findAll() {
        $expression = array('entity' => array(null), 'attributes' => array(null));

        return $this->find($expression);
    }

    public function findBySQL($sql, array $parans=null, $mod_result=null, $cache_life_time=null) {
        if ($conn = Transaction::get()):
            $sth = $conn->prepare($sql);

            if (is_array($parans)) {
                $bindId = 0;
                for ($count = 0; $count < count($parans); $count++) {
                    $param = (string) $parans[$count];
                    $bindId++;
                    $sth->bindParam($bindId, $param, PDO::PARAM_STR);
                }
            }

            $rows = $sth->fetch();

            if (!$rows == 0):
                throw new ModelException('Registros não existem para esta consulta');
                exit;
            endif;

            $sth->execute();

            if ($cache_life_time):
                $time = $cache_life_time;
            else:
                $time = ConfigCache::cacheDefaultLifeTime();
            endif;

            self::$cache = new Cache_Lite(array(
                        'cacheDir' => ConfigCache::cachePath(),
                        'lifeTime' => $time
                    ));

            $id = ConfigCache::cacheLoadMethodId('findBySql');

            if ($mod_result == 'array'):
                if (!$data = self::$cache->get($id)) {
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)):
                        $results[] = $row;
                        self::$cache->save(serialize($results), $id);
                    endwhile;
                }
                else {
                    $results = unserialize($data);
                } elseif ($mod_result == 'object'):
                if (!$data = self::$cache->get($id)) {
                    while ($row = $sth->fetchObject($this->entity)):
                        $results[] = $row;
                        self::$cache->save(serialize($results), $id);
                    endwhile;
                }
                else {
                    $results = unserialize($data);
                }
            endif;
            return $results;
        else:
            throw new ModelException('Exception: no active Transaction');
        endif;
    }
    
	    public function _Q($sql, array $parans=null, $mod_result=null, $cache_life_time=null) {
			
			if ($conn = Transaction::get()):
            $sth = $conn->prepare($sql);
            if (is_array($parans)) {
                $bindId = 1;
				for ($count = 1; $count <= count($parans); $count++){
                    $param =  $parans[$count];
				
					$bindId++;
					if($param){
                        $sth->bindParam($count, $param, PDO::PARAM_STR);
					}
                }
            }
            $rows = $sth->fetch();
            
            if (!$rows == 0):
                throw new ModelException('Registros não existem para esta consulta');
                exit;
            endif;
            
            $sth->execute();
          
            if($mod_result == 'array'):
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)):                      
                        $results[] = $row;
                    endwhile;
            elseif ($mod_result == 'object'):
                    while ($row = $sth->fetchObject($this->entity)):
                        $results[] = $row;
                        self::$cache->save(serialize($results), $id);
                    endwhile;
            endif;
			
			if(isset($results))
			{
				return $results;
			}
			else
			{
			    return false;
			}
        else:
            throw new ModelException('Exception: no active Transaction');
        endif;
    }

    public function load($id=null, Criteria $criteria=null, $col=null, $entity=null, $config=null) {
        if(isset($criteria)):
            $repository = new Repository($this->entity);
			if (isset($col) and !is_null($config)):
                $collection = $repository->load($criteria, $col, $config);
            elseif ($col):
                $collection = $repository->load($criteria, $col);
				
            else:
                $collection = $repository->load($criteria);
				
            endif;
            return $collection;
        endif;

        if (is_numeric($id))
		{
            $collection = $this->findById($id);
            return $collection;
        } else {
            throw new ModelException('ID indevido');
        }
    }
	
	public function verifyResults($results)
	{
	    if(!is_null($results))
		{
		    return $results;
		}
		else
		{   
            return null;
		}
	}

}
