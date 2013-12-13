<?php

class BelongsToFinder extends Relations implements Relatable {

    public function __construct($id, $property,$entity) {
        parent::__construct($id, $property, $entity);
    }

    public function loadExpression() {
        $criteria = new Criteria;
        $criteria->add(new Filter('id', '=', ':id', $this->id));
        $repository = new Repository($this->entity);
        $result = $repository->load($criteria);
		
		
		$criteria2 = new Criteria;
		$criteria2->add(new Filter('id','=',':id', $result[0]->{"{$this->property}_id"}));
		
		$repository2 = new Repository($this->property);
	
		$result2 = $repository2->load($criteria2);
        return $result2[0];
    }
}
?>