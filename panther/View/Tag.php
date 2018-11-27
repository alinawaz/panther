<?php
namespace Panther\View;

use Panther\View\Interfaces\TagInterface;

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

	public function match($search, $view)
	{
		return match($view, $search, $this->find_all);
	}

	public function render($view)
	{
		foreach($this->searches as $search){
			$items = match($view, $search['source'], $this->find_all);
			if($items){
				foreach($items as $item){
					$source = str_replace('*', '', $search['source']);
					$source = str_replace('?', $item, $source);
					$target = str_replace('@replace', $item, $search['target']);
					$view = str_replace($source, $target, $view);
				}
			}
		}
		foreach($this->replaces as $replace){
			$view = str_replace($replace['source'], $replace['target'], $view);
		}
		return $view;
	}

}