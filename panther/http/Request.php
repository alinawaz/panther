<?php

namespace Panther\Http;

class Request implements RequestInterface {
	
	private $variables = [];

	public function get($name){
		return $this->variables[$name];
	}

	public function set($name, $value){
		$this->variables[$name] = $value;
	}

}