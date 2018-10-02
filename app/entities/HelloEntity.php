<?php

namespace App\Entities;

use Panther\Entity\Entity;
use Panther\Http\Request;

class HelloEntity extends Entity {


	public function routes($router){
		$router->get('/', 'index');
		$router->get('/test/:id', 'test');
		$router->get('/call/:number', function($number){
			return $this->toJson([
	    		"status" => "OK",
	    		"message" => "Calling number ".$number." ..."
	    	]);
		});
        $router->post('/save', 'saveName');
        $router->post('/test_post/:name/:age', 'test_post');
    }
    
    public function test_post($name, $age, Request $request){
        return $this->toJson([
    		"status" => "OK",
    		"message" => "Name {".$name."}, Age {".$age."} & Status{".$request->status."} Saved Successfully"
    	]);
    }

	public function saveName(Request $request){
		return $this->toJson([
    		"status" => "OK",
    		"message" => "Name {".$request->name."} Saved Successfully"
    	]);
	}

    public function index(){
    	return $this->toJson([
    		"status" => "OK",
    		"message" => "Hello from entity"
    	]);
    }

    public function test($id){
    	return $this->toJson([
    		"status" => "OK",
    		"message" => "Hello from entity",
    		"param" => "Passed ID is ".$id
    	]);
    }
    
}