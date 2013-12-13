<?php
class Model {

    protected $data;
    protected $results;
    protected $finder;
    protected $attributes;
    private static $cache;
    protected static $post;
    public $message;

    public function __construct() {
        $value[] = func_get_args(0);

        $id = $value[0];

        if (@$id[0] and is_numeric($id[0])) {
            $object = $this->finder()->load($id[0]);
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
            //execulta m�todo set_
            return call_user_func(array(
                $this,
                'get_' . $prop
            ));
        } else {
            //atribui o valor a propriedade
            /* foreach($this->data as $data)
              {
              if(!is_null($data))
              {
              $this->data[$prop] = $data;
              }
              } */
            return $this->data[$prop];
        }
    }

    public function __call($method_name, $arguments) {
        $reflectionClass = new ReflectionClass(get_class($this));
        if ($this->id) {
            foreach ($reflectionClass->getDefaultProperties() as $propertie => $value) {
                if ($method_name == $propertie) {
                    $class = $value[0] . 'Finder';
                    $belongs = new $class($this->id, $propertie, $this->getEntity());
                    return $belongs->loadExpression();
                }
            }
        }
    }

    public function __toString() {
        return $this->data['id'];
    }

    public function getEntity() {
        //obtem o nome da classe
        $classe = strtolower(get_class($this));
        //retorna o nome da classe
        return $classe;
    }

    public function object($class) {
        if ($class instanceof ControllerFactory) {
            $class = get_class($class);
            $class_model = substr($class, 0, -6);
            $model_instance = new $class_model;

            return $model_instance;
        }

        if (is_string($class)) {
            $class = trim("{$class}");
            $model_instance = new $class;
            return $model_instance;
        }
    }

    public function finder($file = null,$repository=null) {
        $class_vars = get_class_vars(get_class($this));
        foreach ($class_vars as $name => $value) {
            if ($name == 'finder' and $value = 'XML') {
                $this->finder = new XMLFinder($file);
                return $this->finder;
            } else {
                $this->finder = new Finder($this->getEntity());

                return $this->finder;
            }
        }
    }

    public function fromArray(array $data) {
        $this->data = $data;
    }

    public function fromObject(array $data) {
        $this->data = $data;
    }

    public function toArray() {
        return $this->data;
    }

    public function encJson() {
        return json_encode($this->data);
    }

    public function toJson() {
        return json_decode($this->data);
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
        $sql = new SqlInsert;
        $sql->setEntity($this->getEntity());

        $binder = new BindParameter;
        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $this->$key);
            $binder->setParam($this->$key);
            $binder->setSymbol($key);
        }/*
		if(isset($this->data['texto']))
		{
			print_r($this->data['texto']);
			exit;
		}*/
        if ($conn = Transaction::get()) {
            if (!$sth = $conn->prepare($sql->getInstruction())) {
                throw new ModelException('Erro ao preparar a instru��o Sql');
            }
            $binder->setPdoStatement($sth);
            $binder->processAbsParameters();
            //execulta query
            if (!$sth->execute()):
                throw new ModelException
                ('query error process');
            endif;
            //retorna valor;
            return $sth;
        }
        else {
            throw new ModelException('no transaction active');
        }
    }

    public function update(Criteria $criteria = null) {
        $sql = new SqlUpdate();
        $sql->setEntity($this->getEntity());

        if ($this->id) {
            $id = $this->id;
            $criteria = new Criteria;
            $criteria->add(new Filter('id', '=', ':id', $id));
        }
        $sql->setCriteria($criteria);
        $binder = new BindParameter();

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $value);
            $binder->setParam($value);
            $binder->setSymbol($key);
        }
        if ($conn = Transaction::get()) {
            //echo $sql->getInstruction();
            if (!$sth = $conn->prepare($sql->getInstruction())) {
                throw new ModelException
                ('(Exception: transaction.prepare) ::: Erro ao Atualizar registro ');
            }
            $binder->setPdoStatement($sth);
            $binder->processAbsParameters();
            //execulta query
            $sth->execute();
            //retorna valor;
            return $sth;
        } else {
            throw new ModelException('(Exception) ::: nao ha transaco ativa');
        }
    }

    public function updateCriteria(Criteria $criteria = null) {
        $sql = new SqlUpdate();
        $sql->setEntity($this->getEntity());

        if (isset($criteria)) {
            unset($this->data['id']);
            $sql->setCriteria($criteria);
        }

        $binder = new BindParameter();
        $binder->setCriteria($criteria);

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $value);
            $binder->setParam($value);
            $binder->setSymbol($key);
        }

        if ($conn = Transaction::get()) {
            //echo $sql->getInstruction();
            if (!$sth = $conn->prepare($sql->getInstruction())) {
                throw new ModelException
                ('(Exception: transaction.prepare) :: Erro ao Atualizar registro ');
            }
            $binder->setPdoStatement($sth);
            $binder->processCriteriaParameters();
            //execulta query
            $sth->execute();
            //retorna valor;
            return $sth;
        } else {
            throw new ModelException('(Exception) ::: nao ha transaco ativa');
        }
    }

    public function destroy() {
        if (is_numeric($this->id)) {
            $id = $this->id;

            $criteria = new Criteria;
            $criteria->add(new Filter('id', '=', ':id', $id));

            $sql = new SqlDelete();
            $sql->setEntity($this->getEntity());
            $sql->setCriteria($criteria);

            if ($conn = Transaction::get()) {
                //prepara o SQL
                if (!$sth = $conn->prepare($sql->getInstruction())) {
                    throw new ModelException
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
                throw new ModelException('(Exception) ::: n�o h� uma transa��o ativa');
            }
        } else {
            throw new ModelException('(Exception) ::: O id informado n�o � um numero');
        }
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
        } catch (ModelException $e) {
            TMessage :: setMessage('Info', $e->getMessage());
            Transaction :: rollback();
        }
    }

    public function setPost($post) {
        self::$post = $post;
        return $this;
    }

    public function setAttributes($post) {
        $this->attributes = $post;
    }

    public function getAttributes() {
        return $this->attributes;
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
