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