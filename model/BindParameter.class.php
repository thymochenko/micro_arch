<?php

class BindParameter {

    protected $param;
    protected $symbol;
    public static $instance;
    protected $criteria;
    protected $expressions;
	protected $column;
    
    public function __construct() {

    }

    public static function create() {
        self::$instance = new BindParameter;
        return self::$instance;
    }

    public static function get() {
        if (!isset(self::$instance)):
            return new self;
        endif;

        return self::$instance;
    }

    public function setCriteria(Criteria $criteria) {
        $this->expressions = $criteria->expressions;
    }

    public function getCriteria() {
        return $this->expressions;
    }

    public function setParam($param) {

        $this->param[] = $param;
    }

    public function getParam() {
        return $this->param;
    }

    public function setSymbol($symbol) {
        $this->symbol[] = $symbol;
        if (is_array($symbol)): $this->symbol = $symbol;
        endif;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function setPdoStatement(PDOStatement $sth) {
        $this->sth = $sth;
    }

    public function getPdoSth() {
        return $this->sth;
    }

    
    public function processCriteriaParameters() {
        if (isset($this->expressions) and isset($this->sth)) {
            $bind = $this->getCriteria();
            foreach($bind as $k => &$bvalue)
			{   
			    if(!$bvalue instanceof Criteria){
                    $symbol = $bvalue->getBindParam();
                    if (is_string($bvalue->getBindValue())) {
                        $bvalue = str_replace("'", '', $bvalue->getBindValue());
						//echo $symbol . " <br>" . $bvalue;
						$this->sth->bindParam($symbol, $bvalue, PDO::PARAM_STR);
                    }					
				}
				else{
				        foreach($bvalue->getExpressions() as $k=>$ctrvalue){
					        $symbol = $ctrvalue->getBindParam();
							
                            if (is_string($ctrvalue->getBindValue())) {
								#echo $ctrvalue->getBindValue();
								$ctrvalue = str_replace("'", '', $ctrvalue->getBindValue());
								
								$this->sth->bindParam($symbol, $ctrvalue, PDO::PARAM_STR);
                            }
					    }
                    }
            }
            return true;
        }
    }
    
    public function processAbsParameters() {
        if (isset($this->param) and isset($this->symbol)) {
            $bind = $this->getParam();
            foreach($bind as $k => &$bvalue)
			{
                $symbol = $this->getSymbol();
                if (is_string($bvalue))
				{ 
				    $this->sth->bindValue($symbol[$k], $bvalue, PDO::PARAM_STR);
                }
            }
       }
	}
}
?>