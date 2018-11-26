<?php

namespace Panther\Database\Migrations\Interfaces;

interface StructureInterface {

	public function get();

	public function increments($column);

	public function string($column, $length=256);

	public function integer($column, $length=11);
	
}