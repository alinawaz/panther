<?php
namespace App\Database\Seeders;

use Panther\Database\Claw as DB;

class ItemSeeder {

	public function run()
	{
		DB::defaultDb()->table('items')->insert([
			'name' => 'Item 1'
		]);

		DB::defaultDb()->table('items')->insert([
			'name' => 'Item 2'
		]);

		DB::defaultDb()->table('items')->insert([
			'name' => 'Item 3'
		]);

		DB::defaultDb()->table('items')->insert([
			'name' => 'Item 4'
		]);

		DB::defaultDb()->table('items')->insert([
			'name' => 'Item 5'
		]);
	}

	public function rollback()
	{
		DB::defaultDb()->table('items')->truncate();
	}

}