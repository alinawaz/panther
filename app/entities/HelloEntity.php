<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;
use Panther\Http\Request;

// Using models
use App\Models\Entry;

class HelloEntity extends EntityController {


	public function routes(Router $router){		
		
        $router->get('/test/:id', 'test');
        
    }

    public function index(){
    	return $this->view('index', ['variable' => 'I am variable from entity!']);
    }
    
    public function test($id){
    	return $this->toJson([
    		"status" => "OK",
    		"message" => "Hello from entity",
            "param" => "Passed ID is ".$id,
            "data" => Entry::find($id)
    	]);
    }
    
}