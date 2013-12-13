<?php

class HttpObjectInstance implements Observable {

    public static function getValues($method, $class=null) {
        if ($method) {
            $strInstance = 'Http_' . $method . 'Collection';
            $instance = new $strInstance;

            if (!$class) {
                return $instance->get();
            }
            return $instance->get($class);
        }
    }

}

?>
