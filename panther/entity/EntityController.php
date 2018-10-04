<?php

namespace Panther\Entity;

class EntityController {
	
	public function toJson($data){
		return json_encode($data);
	}

	public function view($view_file, $data=[]){
		
	}

}