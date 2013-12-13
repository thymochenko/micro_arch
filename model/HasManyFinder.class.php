<?php
class HasManyFinder extends Relations implements Relatable {

    public function __construct($id, $property, $entity) {
       parent::__construct($id,$property,$entity);
    }

    public function loadExpression() {
        $fk_id = $this->entity . '_id';
        $c = new Criteria;
        $c->add(new Filter($fk_id, '=', ':id', $this->id));
        $repository = new Repository($this->property);
        $result = $repository->load($c);
        return $result;
    }

}

?>