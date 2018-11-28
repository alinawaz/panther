<?php
namespace Panther\Core\String;

// Rules
// * expect anything
// ? grab input
// else all exact match

// i.e. *@section(?)?@endsection*

class Traverse
{

	private $string = '';
	private $collected = '';
	private $index = 0;

	function __construct($string)
	{
		$this->string = $string;
	}

	public function get($ignore_last = false)
	{
		if($ignore_last)
			$this->collected = substr($this->collected, 0, -1);
		return $this->collected;
	}

	public function clear()
	{
		$this->collected = '';
	}

	public function skip($number)
	{
		$this->index += $number;
	}

	public function reset()
	{
		$this->index = 0;
	}

	public function is($char)
	{		
		if($this->string[$this->index] == $char){
			return true;
		}
		return false;
	}

	public function next()
	{		
		$this->index++;
	}

	public function hasNext()
	{
		if(isset($this->string[$this->index])){
			$this->collected .= $this->string[$this->index];
			return true;
		}
		return false;
	}

}