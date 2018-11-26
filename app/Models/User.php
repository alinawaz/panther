<?php

namespace App\Models;

use Panther\Database\Model;
use Panther\Security\Auth;

class User extends Model
{
	protected static $table = 'users';

	public function authenticate($email, $password)
	{
		$auth = new Auth(get_class());
		return $auth->authenticate($email, $password);
	}
}