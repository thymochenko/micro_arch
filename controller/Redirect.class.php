<?php

class Redirect {

    protected $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function display() {
        header(' Location: ' . $this->url);
        exit;
    }

}