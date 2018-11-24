<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;
use Panther\Http\Request;

// Using models
use App\Models\Entry;

class HelloEntity extends EntityController {


	public function routes(Router $router){		
		
        $router->get('/hello/:id', 'HelloEntity@test');
        
    }

    public function index(){
    	return $this->view('index', ['variable' => 'I am variable from entity!']);
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

    public function test($id){
    	return $this->toJson([
    		"status" => "OK",
    		"message" => "Hello from entity",
            "param" => "Passed ID is ".$id,
            "data" => Entry::find($id)
    	]);
    }
    
}