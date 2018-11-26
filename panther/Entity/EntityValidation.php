<?php

namespace Panther\Entity;

use Panther\Http\Request;

class EntityValidation
{

	private $request;

	function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function validate($rules)
	{
		$errors = [];
		foreach($rules as $key => $value){
			if($this->request->get($key) === FALSE){
				throw new \Exception('Request variable '.$key.' not found.');
			}
			if($value == ''){
				throw new \Exception('Rule for request variable '.$key.' not found.');
			}
			$rule_array = explode('|', $value);
			if($this->applyRules($rule_array, $key) !== NULL)
				$errors[] = $this->applyRules($rule_array, $key);			
		}
		$temp = new \StdClass();
		$temp->count = count($errors);
		$temp->errors = $errors;
		return $temp;
	}

	private function applyRules($rules, $key)
	{
		foreach($rules as $rule){
			if($this->applyRule($rule, $key) !== NULL)
				return $this->applyRule($rule, $key);
		}
	}

	private function applyRule($rule, $key)
	{
		if($rule == 'required'){
			if($this->request->get($key) == ''){
				return $key.' is required';
			}
		}else{
			throw new \Exception('Invalid rule: '.$rule);
		}
		return NULL;
	}

}