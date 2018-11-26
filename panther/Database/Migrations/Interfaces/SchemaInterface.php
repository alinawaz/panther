<?php

namespace Panther\Database\Migrations\Interfaces;

interface SchemaInterface {

	public function create($table_name, $structure);

	public function drop($table_name);
	
}