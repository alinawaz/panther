<?php

namespace App\Entities;

class HelloEntity {


	public function routes($router){
		$router->get('/', 'index');
		$router->get('/test', 'test');
	}

    public function index(){
    	echo "Hello from entity";
    }

    public function test(){
    	echo "Hello form test method of entity";
    }
    
}