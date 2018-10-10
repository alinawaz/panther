<?php

namespace Panther\Http;

use Panther\Http\Interfaces\RequestInterface;

class Request implements RequestInterface {
	
	private $variables = [];

	function __construct($post_variables = []){
		$this->variables = $post_variables;
		foreach($post_variables as $key => $value){
			$this->$key = $value;
		}
	}

	public function get($name){
		if(isset($this->variables[$name]))
		{
			return $this->variables[$name];
		}
		return false;
	}

	public function set($name, $value){
		$this->variables[$name] = $value;
	}
	
	public function flush(){
		foreach($this->variables as $key => $value){
			unset($this->$key);
		}
		$this->variables = [];
	}

	// Filter: filter post variable based on passed $key or array of keys
	// Overrides current instacne post variable
	public function filter($nameOrArray){
		foreach($this->variables as $key => $value){
			unset($this->$key);
		}
		$new_values = [];
		if(is_array($nameOrArray)){
			foreach($this->variables as $key => $value){
				if(!in_array($key, $nameOrArray)){
					$new_values[$key] = $value;
				}
			}
		}else{
			foreach($this->variables as $key => $value){
				if($key != $nameOrArray){
					$new_values[$key] = $value;
				}
			}
		}
		foreach($new_values as $key => $value){
			$this->$key = $value;
		}
		$this->variables = $new_values;
	}

	// Except: filter post variable based on passed $key or array of keys
	// Returns array
	public function except($nameOrArray){
		$new_values = [];
		if(is_array($nameOrArray)){
			foreach($this->variables as $key => $value){
				if(!in_array($key, $nameOrArray)){
					$new_values[$key] = $value;
				}
			}
		}else{
			foreach($this->variables as $key => $value){
				if($key != $nameOrArray){
					$new_values[$key] = $value;
				}
			}
		}
		return $new_values;
	}

}