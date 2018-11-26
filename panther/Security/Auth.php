<?php
namespace Panther\Security;

use Panther\Security\Session;

class Auth
{

	private $model = NULL;
	private $field_username = 'email';
	private $field_password = 'password';

	function __construct($model)
	{
		$this->model = $model;
	}

	public function authenticate($username, $password)
	{
		$user = $this->model::where([
			$this->field_username => $username,
			$this->field_password => $password
		])->first();
		if($user)
		{
			Session::set('auth_id', $user->id);
			return $user->token;
		}
		return false;
	}

	public function user()
	{
		return $this->model::where('id', Session::get('auth_id'))->first();
	}

}