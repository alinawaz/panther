<?php

namespace Panther\Http;

class Request implements RequestInterface {
	
	private $variables = [];

	function __construct($post_variables = []){
		$this->variables = $post_variables;
		foreach($post_variables as $key => $value){
			$this->$key = $value;
		}
	}

	public function get($name){
		return $this->variables[$name];
	}

	public function set($name, $value){
		$this->variables[$name] = $value;
	}

	public function except($nameOrArray){
		$new_values = [];
		if(is_array($nameOrArray)){
			foreach($this->variables as $key => $value){
				if(!in_array($key, $nameOrArray)){
					$new[$key] = $value;
				}
			}
		}else{
			foreach($this->variables as $key => $value){
				if($key != $nameOrArray){
					$new[$key] = $value;
				}
			}
		}
		return $new_values;
	}

}