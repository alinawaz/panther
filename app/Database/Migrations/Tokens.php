<?php
namespace App\Database\Migrations;

use Panther\Database\Migrations\Interfaces\SchemaInterface;
use Panther\Database\Migrations\Interfaces\StructureInterface;

class Tokens {

	private $schema;

	function __construct(SchemaInterface $schema)
	{
		$this->schema = $schema;
	}

	public function up()
	{
		$this->schema->create('tokens', function(StructureInterface $table){
			$table->increments('id');
			$table->string('name')->required();
			$table->string('code')->required();
		});
	}

	public function down()
	{
		$this->schema->drop('tokens');
	}

}