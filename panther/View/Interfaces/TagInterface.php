<?php
namespace Panther\View\Interfaces;

interface TagInterface
{
	
	public function find($search, $replace);

	public function findStartWith($search, $replace);

	public function findEndWith($search, $replace);

	public function findAnywhere($search, $replace);

	public function render($view);

}