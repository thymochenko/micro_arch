<?php
interface Pluggable
{
    public function __construct(array $options);
	
	public function initialize();
}
?>