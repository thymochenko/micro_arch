<?php
class SimpleTemplateComponent extends LoadTemplateEnginer implements Pluggable {

    public function __construct(array $options) {
        parent::__construct($options);
        $this->initialize();
    }

    public function initialize() {
        $path = ConfigPath::pathAppBase();

        $lz_tpl = $path . '/protected/views/views.' . $this->getActionReference() . '/' .$this->template . '.html';
        $tpl = new Template($lz_tpl);
        $tpl->set($this->getActionReference(), $this->collection);

        echo $tpl->fetch($lz_tpl);
    }

}
?>