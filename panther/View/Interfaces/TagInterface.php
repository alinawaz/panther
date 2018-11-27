<?php
namespace Panther\View\Interfaces;

interface TagInterface
{
	
	public function replace($search, $replace, $content);

	public function find($search, $replace);

	public function findStartWith($search, $replace);

	public function findEndWith($search, $replace);

	public function findAnywhere($search, $replace);

	public function match($search, $content);

	public function render($content);

}