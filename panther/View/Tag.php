<?php
namespace Panther\View;

use Panther\View\Interfaces\TagInterface;

use Panther\Core\String\Find;

class Tag implements TagInterface
{
	
	private $searches = [];
	private $replaces = [];
	public $find_all = true;

	public function replace($search, $replace, $content = NULL)
	{
		if($content != NULL){
			return str_replace($search, $replace, $content);
		}
		
		$this->replaces[] = [
			'source' => $search,
			'target' => $replace
		];
	}

	public function find($search, $replace)
	{
		$this->searches[] = [
			'source' => $search,
			'target' => $replace
		];
	}

	public function findStartWith($search, $replace)
	{
		$this->searches[] = [
			'source' => $search.'*',
			'target' => $replace
		];
	}

	public function findEndWith($search, $replace)
	{
		$this->searches[] = [
			'source' => '*'.$search,
			'target' => $replace
		];
	}

	public function findAnywhere($search, $replace)
	{
		$this->searches[] = [
			'source' => '*'.$search.'*',
			'target' => $replace
		];
	}

	public function match($search, $content)
	{
		$find = new Find($content);
		return $find->match($search);				
		//return match($content, $search, $this->find_all);
	}

	public function render($content)
	{
		foreach($this->searches as $search){
			$items = match($content, $search['source'], $this->find_all);
			if($items){
				foreach($items as $item){
					$source = str_replace('*', '', $search['source']);
					$source = str_replace('?', $item, $source);
					$target = str_replace('@replace', $item, $search['target']);
					$content = str_replace($source, $target, $content);
				}
			}
		}
		foreach($this->replaces as $replace){
			$content = str_replace($replace['source'], $replace['target'], $content);
		}
		return $content;
	}

}