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
		if(getenv('DB_DEFAULT')=='MYSQL')
			return new MysqlQuery;
		return new MysqlQuery;
	}

}