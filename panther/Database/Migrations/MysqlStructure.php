<?php

namespace Panther\Database\Migrations;

use Panther\Database\Migrations\Interfaces\StructureInterface;

use Panther\Database\Migrations\Fields\MysqlIncrement;
use Panther\Database\Migrations\Fields\MysqlString;
use Panther\Database\Migrations\Fields\MysqlInteger;

class MysqlStructure implements StructureInterface {

	private $queries = [];

	public function get(){
		$string = '';
		foreach($this->queries as $query)
		{
			if($string == ''){
				$string = $query->get();
			}else{
				$string .= ',' . $query->get();
			}
		}
		return $string;
	}

	public function increments($column){
		$field = new MysqlIncrement($column);
		$this->queries[] = &$field;
		return $field;
	}

	public function string($column, $length=255){
		$field = new MysqlString($column, $length);
		$this->queries[] = &$field;
		return $field;
	}

	public function integer($column, $length=11){
		$field = new MysqlInteger($column, $length);
		$this->queries[] = &$field;
		return $field;
	}

}