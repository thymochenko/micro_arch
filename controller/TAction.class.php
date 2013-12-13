<?php
class TAction
{
	private $action;
	private $param;

	public function __construct($action) {
		$this->action = $action;
	}

	public function setParameter($param, $value) {
		$this->param[$param] = $value;
	}

	public function serialize()
	{
		//verifica se a ação é um metodo
		if (is_array($this->action)) {
			//obtem o nome da classe
			$url['class'] = $this->action[0];
			//obtem o nome do metodo
			$url['method'] = $this->action[1];
		}
		elseif (is_string($this->action)) {

			$url['method'] = $this->action;
		}

		//verifica se há parametros
		if ($this->param) {
			$url = array_merge($url, $this->param);
		}
		//monta a url
		return '?' . http_build_query($url);
	}
}