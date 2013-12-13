<?php

class StrategyConfiguration {

    protected $type, $class, $plug_in_prefix;

    public function __construct($prefix)
	{
        $this->plug_in_prefix = $prefix;
    }
    
    public function getTypeConfFiles(array $type) 
	{
        $this->type = $type;
		
        for ($i = 0; $i < count($this->type); $i++) {
            $this->class = $this->plug_in_prefix . $this->type[$i];
            if (class_exists($this->class)) {
                return new $this->class;
            } else {
                throw new CoreException('Error create plug-in Instance');
            }
        }
    }

}

?>
