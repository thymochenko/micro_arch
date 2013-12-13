<?php

class ActiveRecordLayer {

    protected $data;
    protected static $tRecord_meta;
    protected static $children_ob_acess;
    protected $results;
    private static $cache;
    protected static $post;

    public function __construct() {
        $value[] = func_get_args(0);

        $id = $value[0];

        if (@$id[0] and is_numeric($id[0])) {
            $object = $this->load($id[0]);
            if ($object) {
                $this->fromArray($object->toArray());
                //destroi os resultados armazenados na var results. (ao menos no construtor)
                unset($this->results);
            }
            return true;
        }

        $parans = func_get_args(0);
        @$parans = $parans[0];

        if ($parans) {
            $this->fromArray($parans);
            return true;
        }
    }

    public function __set($prop, $value) {
        if (method_exists($this, 'set_' . $prop)) {
            //execulta mï¿½todo set_
            call_user_func(array(
                $this,
                'set_' . $prop
                    ), $value);
        } else {
            //atribui o valor a propriedade
            $this->data[$prop] = $value;
        }
    }

    public function __get($prop) {
        if (method_exists($this, 'get_' . $prop)) {
            //execulta mï¿½todo set_
            return call_user_func(array(
                $this,
                'get_' . $prop
            ));
        } else {
            //atribui o valor a propriedade
            return $this->data[$prop];
        }
    }

    public function __call($method_name, $arguments) {
        $reflectionClass = new ReflectionClass(get_class($this));
        if ($this->id) {
            foreach ($reflectionClass->getDefaultProperties() as $propertie => $value) {
                if ($method_name == $propertie) {
                    if ($value[0] == 'belongs_to') {
                        $belongs = new BelongsToFinder($this->id, $propertie);
                        return $belongs->loadExpression();
                    } elseif ($value[0] == 'has_many') {
                        $hasmany = new HasManyFinder($this->id, $propertie, $this->getEntity());
                        return $hasmany->loadExpression();
                    } elseif ($value[0] == 'has_and_belongs_to_many') {
                        $hasbelong = new HasAndBelongsToManyFinder($this->id, $propertie, $this->getEntity());
                        return $hasbelong->loadExpression();
                    }
                }
            }
        }
    }

    public function getEntity() {
        //obtem o nome da classe
        $classe = strtolower(get_class($this));
        //retorna o nome da classe
        return substr($classe, 0, -6);
    }

    public function object($class) {
        if ($class instanceof ControllerFactory) {
            $class = get_class($class);
            $class = "{$class}Record";
            $model_instance = new $class;
            return $model_instance;
        }

        if (is_string($class)) {
            $class = "{$class}Record";
            $model_instance = new $class;
            return $model_instance;
        }
    }

    public function fromArray(array $data) {
        $this->data = $data;
    }

    public function toArray() {
        return $this->data;
    }

    public function __clone() {
        unset($this->id);
    }

    public function __unset($name) {
        if ($name == 'insert'):
            unset($this->data[$name]);
        elseif ($name == 'update'):
            unset($this->data[$name]);
        elseif ($name == 'delete'):
            unset($this->data[$name]);
        endif;
    }

    public function store() {
        $sql = new LzSqlInsert;
        $sql->setEntity($this->getEntity());

        $binder = new BindParameter;

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $this->$key);

            $binder->setParam($this->$key);

            $binder->setSymbol($key);
        }
        if ($conn = Transaction::get()) {
            if (!$sth = $conn->prepare($sql->getInstruction())) {
                throw new ActiveRecordLayerException('Erro ao preparar a instruï¿½ï¿½o Sql');
            }
            $binder->setPdoStatement($sth);
            $binder->processAbsParameters();
            //execulta query
            if (!$sth->execute()):throw new ActiveRecordLayerException
                        ('Erro na execuï¿½ï¿½o da query: query nï¿½o execultada');
            endif;
            //retorna valor;
            return $sth;
        }
        else {
            throw new ActiveRecordLayerException('nï¿½o hï¿½ uma transaï¿½ï¿½o ativa');
        }
    }

    public function update() {
        $id = $this->id;

        $criteria = new Criteria;
        $criteria->add(new Filter('id', '=', ':id', $id));

        $sql = new LzSqlUpdate();
        $sql->setEntity($this->getEntity());
        $sql->setCriteria($criteria);

        $binder = new BindParameter();

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $this->$key);
            $binder->setParam($this->$key);
            $binder->setSymbol($key);
        }

        if ($conn = Transaction::get()) {
            if (!$sth = $conn->prepare($sql->getInstruction())) {
                throw new ActiveRecordLayerException
                        ('(Exception: transaction.prepare) ::: Erro ao Atualizar registro ');
            }
            $binder->setPdoStatement($sth);
            $binder->processAbsParameters();
            //execulta query
            $sth->execute();
            //retorna valor;
            return $sth;
        } else {
            throw new ActiveRecordLayerException('(Exception) ::: nï¿½o hï¿½ transaï¿½ï¿½o ativa');
        }
    }

    public function destroy() {
        if (is_numeric($this->id)) {
            $id = $this->id;

            $criteria = new Criteria;
            $criteria->add(new Filter('id', '=', ':id', $id));

            $sql = new LzSqlDelete();
            $sql->setEntity($this->getEntity());
            $sql->setCriteria($criteria);

            if ($conn = Transaction::get()) {
                //prepara o SQL
                if (!$sth = $conn->prepare($sql->getInstruction())) {
                    throw new ActiveRecordLayerException
                            ('(Exception: transaction.prepare) ::: Erro ao destruir registro ');
                }

                $binder = new BindParameter();
                $binder->setCriteria($criteria);
                $binder->setPdoStatement($sth);
                $binder->processCriteriaParameters();
                //execulta query
                $sth->execute();
                //retorna valor;
                return $sth;
            } else {
                throw new ActiveRecordLayerException('(Exception) ::: nï¿½o hï¿½ uma transaï¿½ï¿½o ativa');
            }
        } else {
            throw new ActiveRecordLayerException('(Exception) ::: O id informado nï¿½o ï¿½ um numero');
        }
    }

    public function load($id=null, Criteria $criteria=null, $col=null) {
        if (isset($criteria)):
            $repository = new Repository($this->getEntity());
            if (isset($col)):
                $collection = $repository->load($criteria, $col);
            else:
                $collection = $repository->load($criteria);
            endif;
            return $collection;
        endif;

        if (is_numeric($id)) {
            $criteria = new TCriteria;
            $criteria->add(new TFilter('id', '=', ':id', $id));
            $collection = $this->load(null, $criteria);

            return $collection;
        } else {
            throw new ActiveRecordLayerException('ID indevido');
        }
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
                throw new ActiveRecordLayerException('Registros nï¿½o existem para esta consulta');
                exit;
            endif;

            $sth->execute();

            if ($cache_life_time):
                $time = $cache_life_time;
            else:
                $time = LzConfigCache::cacheDefaultLifeTime();
            endif;

            self::$cache = new Cache_Lite(array(
                        'cacheDir' => LzConfigCache::cachePath(),
                        'lifeTime' => $time
                    ));

            $id = LzConfigCache::cacheLoadMethodId('findBySql');

            if ($mod_result == 'array'):
                if (!$data = self::$cache->get($id)) {
                    while ($row = $sth->fetch(PDO :: FETCH_BOTH)):
                        $results[] = $row;
                        self::$cache->save(serialize($results), $id);
                    endwhile;
                }
                else {
                    $results = unserialize($data);
                } elseif ($mod_result == 'object'):
                if (!$data = self::$cache->get($id)) {
                    while ($row = $sth->fetchObject($this->getEntity() . 'Record')):
                        $results[] = $row;
                        self::$cache->save(serialize($results), $id);
                        echo 'sem cache';
                    endwhile;
                }
                else {
                    $results = unserialize($data);
                }
            endif;
            return $results;
        else:
            throw new ActiveRecordLayerException('Exception: nï¿½o hï¿½ transaï¿½ï¿½o ativa');
        endif;
    }

    protected function getRepository(Criteria $criteria, $column = null, $method = null) {
        try {
            $repository = new Repository($this->getEntity());

            switch ($method) {
                case 'delete' :
                    $assignObject = $repository->delete($criteria);
                    if ($assignObject == NULL) {
                        throw new RepositoryException
                                ('no existem resultados para esta consulta');
                    }
                    return $assignObject;
                    break;
                case 'count' :
                    $assignObject = $repository->count($criteria);
                    if ($assignObject == NULL) {
                        throw new RepositoryException
                                ('no existem resultados para esta consulta');
                    }
                    return $assignObject;
                    break;
                default :
                    $assignObject = $repository->load($criteria, $column);
                    if ($assignObject == NULL) {
                        throw new RepositoryException('nenhum Registro encontrado');
                    }
                    return $assignObject;
            }
        } catch (ActiveRecordLayerException $e) {
            TMessage :: setMessage('Info', $e->getMessage());
            TTransaction :: rollback();
        }
    }

    /*
     * 'limit'=>2,'order'=>array('id'=>'desc')
     */

    public function find(array $properties) {

        $c = new Criteria;
        $prop = new stdClass;

        if (!empty($properties['and'])) {
            $prop->and[] = array_values($properties['and']);
        }

        if ($properties['entity'] == null) {
            $repository = new Repository($properties['entity']);
        } else {
            $repository = new Repository($this->getEntity());
        }

        if (isset($properties['where'])) {
            $c->add(new Filter($properties['where'][0], $properties['where'][1], $properties['where'][2], $properties['where'][3]));
        }

        if (isset($prop->and[0])) {
            foreach ($prop->and[0] as $k => $propert) {
                $filters[$k] = $propert;
            }

            if (!empty($filters[4])) {
                $c->add(new Filter($filters[4][0], $filters[4][1], $filters[4][2], $filters[4][3]));
            }

            if (!empty($filters[4]['and'])) {
                $c->add(new Filter($filters[4]['and'][0], $filters[4]['and'][1], $filters[4]['and'][2], $filters[4]['and'][3]));
            }

            if ($filters) {
                $c->add(new Filter($filters[0], $filters[1], $filters[2], $filters[3]));
            } else {
                throw ModelException('erro ai adicionar parametros no método find');
            }
        }

        if (isset($properties['or'])) {
            foreach ($properties['or'] as $k => $orpropert) {
                $orfilters[$k] = $orpropert;
            }
        }
        if (isset($orfilters)) {
            $c->add(new Filter($orfilters[0], $orfilters[1], $orfilters[2], $orfilters[3]), TExpression::OR_OPERATOR);
        }

        if (isset($properties['order'])) {
            $key = array_keys($properties['order']);
            $value = array_values($properties['order']);
        }

        if (isset($key) and isset($value)) {
            $c->setProperty('limit', $properties['limit'][0]);
            $c->setProperty('order', $key[0] . ' ' . $value[0]);
        }

        if (!is_null($properties['attributes'][0])) {
            $result = $repository->load($c, array_values($properties['attributes']));
            return $result;
        }

        $result = $repository->load($c);
        return $result;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $expression = array(
                'entity' => array(null),
                'attributes' => array(null),
                'where' => array('id', '=', ':id', $id)
            );

            return $this->find($expression);
        }
        else{
            throw new ActiveRecordLayerException('parametro Id não é um inteiro');
        }
    }

    public function findAll(){
        $expression=array('entity'=>array(null), 'attributes'=>array(null));
        return $this->find($expression);
    }

    public function setPost($post) {
        self::$post = $post;
        return $this;
    }

    protected function getPost() {
        return self::$post;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

}