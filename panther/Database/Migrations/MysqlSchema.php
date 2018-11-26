<?php

namespace Panther\Database\Migrations;

use Panther\Core\ErrorView;
use Panther\Database\MysqlQuery as DB;
use Panther\Database\Migrations\Interfaces\SchemaInterface;
use Panther\Database\Migrations\MysqlStructure;

class MysqlSchema implements SchemaInterface {

	public function create($table, $closure){
		$structure = new MysqlStructure;
		$closure($structure);
		DB::query("CREATE TABLE ".$table." ( ".$structure->get()." )");
	}

	public function drop($table){
		DB::query("DROP TABLE ".$table);
	}

}