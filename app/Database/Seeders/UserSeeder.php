<?php
namespace App\Database\Seeders;

use Panther\Database\Claw as DB;

class UserSeeder {

	public function run()
	{
		DB::defaultDb()->table('users')->insert([
			'name' => 'Ali',
			'email' => 'alinawazsolid@gmail.com',
			'password' => '123',
			'token' => '123456'
		]);
	}

	public function rollback()
	{
		DB::defaultDb()->table('users')->truncate();
	}

}