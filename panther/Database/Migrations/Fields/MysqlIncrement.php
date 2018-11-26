<?php
namespace Panther\Database\Migrations\Fields;

use Panther\Database\Migrations\Fields\Interfaces\IncrementInterface;

class MysqlIncrement implements IncrementInterface
{
	
	private $query = '';

	function __construct($name)
	{
		$this->query .= $name . ' INT(11) PRIMARY KEY auto_increment NOT NULL ';
		return $this;
	}

	public function get()
	{
		return $this->query;
	}

}