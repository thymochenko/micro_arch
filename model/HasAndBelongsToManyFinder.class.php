<?php

class HasAndBelongsToManyFinder extends Relations implements Relatable {

    public function __construct($id, $property, $entity) {
        parent::__construct($id,$property,$entity);
    }

    public function loadExpression() {
        $fk_id = $this->entity . '_id';
        
        $to_many_entity = $this->property . '_' . $this->entity;
       
        $c = new Criteria;
        $c->addJoin(
                array($to_many_entity => "{$to_many_entity}.{$fk_id} = {$this->entity}.id"),
                array($this->property => "{$this->property}.id = {$to_many_entity}.{$this->property}_id")
        );
		$c->add(new Filter("$fk_id",'=',':id',$this->id));
		
        $repository = new Repository($this->entity);
        $result = $repository->load($c);
        return $result;
    }
}
?>