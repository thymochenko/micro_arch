<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Partial
 *
 * @author thymochenko
 */
class Partial {
    //put your code here
    protected $object;
    static $instance;
    
    public static function singleton(){
        if(!isset(self::$instance)){
            return new self;
        }
        return self::$instance;
    }


    public static function init(){
        if(!isset(self::$instance)){
            return new self;
        }
        return self::$instance;
    }

    public function clazz($objectName){
        $this->object=new $objectName;
        return $this;
    }

    public function method($method){
        $result=$this->object->{"{$method}"}();
        return $result;
    }

    public function module($objectName){
        $this->object = new $objectName;
        return $this;
    }

    public function message($method){
        $result=$this->object->{"{$method}"}();
        return $result;
    }
}
?>