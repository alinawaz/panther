<?php
namespace Panther\Database\Migrations\Fields;

use Panther\Database\Migrations\Fields\Interfaces\StringInterface;

class MysqlString implements StringInterface
{
	
	private $query = '';

	function __construct($name, $length=255)
	{
		$this->query .= $name . ' VARCHAR('.$length.')';
		return $this;
	}

	public function get()
	{
		return $this->query;
	}

	public function default($value)
	{
		$this->query .= ' DEFAULT "' . $value . '"';
		return $this;
	}

	public function optional()
	{
		$this->query .= ' NULL';
		return $this;
	}

	public function required()
	{
		$this->query .= ' NOT NULL';
		return $this;
	}

}