<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;
use Panther\Http\Request;

class HelloEntity extends EntityController {


	public function routes(Router $router){		
		$router->get('/test/:id', 'test');
		$router->get('/call/:number', function($number){
			return $this->toJson([
	    		"status" => "OK",
	    		"message" => "Calling number ".$number." ..."
	    	]);
		});
        $router->post('/save', 'saveName');
        $router->post('/test_post/:name/:age', 'test_post');
        $router->put('/save', 'updateName');
        $router->patch('/save/:id', 'patchName');
        $router->delete('/remove/:id', 'remove');
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

    public function updateName(Request $request){
        return $this->toJson([
            "status" => "OK",
            "message" => "Name {".$request->name."} Updated Successfully"
        ]);
    }

    public function patchName($id, Request $request){
        return $this->toJson([
            "status" => "OK",
            "message" => "Name {".$request->name."} of ID {".$id."} Patched Successfully"
        ]);
    }

    public function remove($id){
        return $this->toJson([
            "status" => "OK",
            "message" => "ID {".$id."} deleted Successfully"
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