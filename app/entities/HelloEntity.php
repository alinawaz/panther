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
        $router->post('/hello', 'HelloEntity@test_post');
        
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

    public function test_post(Request $request){
        
        $validation = $this->validate($request, [
            'id' => 'required'
        ]);

        if($validation->count > 0){
            return $this->toJson([
                "status" => false,
                "errors" => $validation->errors
            ]);
        }

        return $this->toJson([
            "status" => true,
            "param" => "Passed ID is ".$request->id,
            "data" => Entry::find($request->id)
        ]);

    }
    
 //    public function test_post($name, $age, Request $request){
 //        return $this->toJson([
 //    		"status" => "OK",
 //    		"message" => "Name {".$name."}, Age {".$age."} & Status{".$request->status."} Saved Successfully"
 //    	]);
 //    }

	// public function saveName(Request $request){
	// 	return $this->toJson([
 //    		"status" => "OK",
 //    		"message" => "Name {".$request->name."} Saved Successfully"
 //    	]);
	// }

 //    public function updateName(Request $request){
 //        return $this->toJson([
 //            "status" => "OK",
 //            "message" => "Name {".$request->name."} Updated Successfully"
 //        ]);
 //    }

 //    public function patchName($id, Request $request){
 //        return $this->toJson([
 //            "status" => "OK",
 //            "message" => "Name {".$request->name."} of ID {".$id."} Patched Successfully"
 //        ]);
 //    }

 //    public function remove($id){
 //        return $this->toJson([
 //            "status" => "OK",
 //            "message" => "ID {".$id."} deleted Successfully"
 //        ]);
 //    }    

 //    public function test($id, Request $request){
        
 //        $this->validate($request, [
 //            'id' => 'required'
 //        ]);

 //    	return $this->toJson([
 //    		"status" => "OK",
 //    		"message" => "Hello from entity",
 //            "param" => "Passed ID is ".$id,
 //            "data" => Entry::find($id)
 //    	]);

 //    }
    
}