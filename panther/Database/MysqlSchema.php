<?php

namespace Panther\Database;

use Panther\Core\ErrorView;
use Panther\Database\MysqlQuery as DB;
use Panther\Database\Interfaces\SchemaInterface;
use Panther\Database\MysqlStructure;

class MysqlSchema implements SchemaInterface {

	public function create($table, $closure){
		$structure = new MysqlStructure;
		$closure($structure);
		dd($structure->get());
		DB::query("CREATE TABLE ".$table." ( ".$structure->get()." )");
	}

	public function drop($table){
		DB::query("DROP TABLE ".$table);
	}

}