<?php
namespace Panther\Security;

class Session
{

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public static function get($key)
	{
		if(isset($_SESSION[$key]))
			return $_SESSION[$key];
		return NULL;
	}

}