<?php
namespace App\Database\Seeders;

use Panther\Database\Claw as DB;

class UserSeeder {

	public function run()
	{
		DB::defaultDb()->table('users')->insert([
			'name' => 'Ali',
			'email' => 'alinawaz@email.com',
			'password' => '123'
		]);
	}

	public function rollback()
	{
		DB::defaultDb()->table('users')->truncate();
	}

}