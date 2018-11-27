<?php
namespace Panther\Security;

use Panther\Security\Session;
use Panther\Http\Request;
use Panther\Database\Claw as DB;
use Panther\Core\ErrorView;

class Auth
{

	public static function login(Request $request)
	{
		$table = getenv('AUTH_TABLE');
		$username = getenv('AUTH_COL_USERNAME');
		$password = getenv('AUTH_COL_PASSWORD');

		$user = DB::defaultDb()
				->table($table)
				->where([
					$username => $request->get($username),
					$password => $request->get($password)
				])
				->first();

		if($user){
			Session::set('auth_id', $user->id);
			return $user->token;
		}
		return false;
	}

	public static function logout()
	{
		Session::puff('auth_id');
	}

	public static function secure($route, $request, $closure)
	{
		if($route->getAuth()){
	        if($request->get('token') == false){
	            ErrorView::render('Security', 'Authentication token is required.');
	        }else{
	            if($request->get('token') == self::user()->token){
	                return $closure($route);
	            }else{
	                ErrorView::render('Security', 'You are not authorized.');
	            }
	        }
    	} 
    	return $closure($route);  
	}

	public static function user()
	{
		$table = getenv('AUTH_TABLE');
		return DB::defaultDb()
				->table($table)
				->where('id', Session::get('auth_id'))
				->first();
	}

}