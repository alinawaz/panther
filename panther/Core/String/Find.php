<?php
namespace Panther\Core\String;

use Panther\Core\ErrorView;
use Panther\Core\String\Traverse;

// Rules
// * expect anything
// ? grab input
// else all exact match

// i.e. *@section(?)?@endsection*

class Find
{

	private $string = '';

	function __construct($string)
	{
		$this->string = $string;
	}

	public function match($rule)
	{
		$rules = $this->parse($rule);
		$rules = $this->refine($rules);
		$tags = [];
		$index = 0;
		for($i=0; $i<count($rules);$i++){			
			$rule = $rules[$i];
			$tokens = $this->getBetween($rule['start'], $rule['end']);
			foreach($tokens as $token){
				if($token != ''){
					$tags[$index][] = $token;
					$index++;
				}				
			}	
			$index = 0;		
		}
		return $tags;
	}

	function getBetween($start, $end){
	    $contents = array();
		$startDelimiterLength = strlen($start);
		$endDelimiterLength = strlen($end);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($this->string, $start, $startFrom))) {
			$contentStart += $startDelimiterLength;
			$contentEnd = strpos($this->string, $end, $contentStart);
			if (false === $contentEnd) {
			  break;
			}
			$contents[] = substr($this->string, $contentStart, $contentEnd - $contentStart);
			$startFrom = $contentEnd + $endDelimiterLength;
		}
		return $contents;
	}

	private function refine($rules)
	{
		$refined_rules = [];
		for ($i = 0; $i < count($rules) ; $i++) {
			if($rules[$i] == '?'){
				if(!isset($rules[$i-1]))
					ErrorView::render('Find Error', 'Invalid rule for ?');
				if(!isset($rules[$i+1]))
					ErrorView::render('Find Error', 'Invalid rule for ?');
				$refined_rules[] = [
					'action' => 'get',
					'start' => $rules[$i-1],
					'end' => $rules[$i+1]
				];
			}
		}
		return $refined_rules;
	}

	private function parse($rule)
	{
		$tokens = [];
		$t = new Traverse($rule);
		while($t->hasNext()){			
			if($t->is('*')){ // anything
				if($t->get() != ''){										
					$tokens[] = $t->get(true);
					$tokens[] = '*';
					$t->clear();
				}
			}else if($t->is('?')){ // grab
				if($t->get() != ''){
					$tokens[] = $t->get(true);
					$tokens[] = '?';
					$t->clear();
				}
			}
			$t->next();
		}
		if($t->get() != ''){
			$tokens[] = $t->get(); // grab remaining
		}
		foreach($tokens as $key => $value){
			if($value == '')
				unset($tokens[$key]);
		}
		return array_values($tokens);
	}

}