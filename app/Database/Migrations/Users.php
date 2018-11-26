<?php
namespace App\Database\Migrations;

use Panther\Database\Migrations\Interfaces\SchemaInterface;
use Panther\Database\Migrations\Interfaces\StructureInterface;

class Users {

	private $schema;

	function __construct(SchemaInterface $schema)
	{
		$this->schema = $schema;
	}

	public function up()
	{
		$this->schema->create('users', function(StructureInterface $table){
			$table->increments('id');
			$table->string('name')->required();
			$table->string('email')->required();
			$table->string('password')->required();
			$table->integer('status')->default(1);
		});
	}

	public function down()
	{
		$this->schema->drop('users');
	}

}