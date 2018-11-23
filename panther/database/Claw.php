<?php

/**
 *
 * Panther MVC ORM [CLAW]
 *
 */


namespace Panther\Database;

use Panther\Database\MysqlQuery;

class Claw {

	public static function defaultDb(){
		if(config('db.default')=='mysql')
			return new MysqlQuery;
		return new MysqlQuery;
	}

}