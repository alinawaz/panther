<?php

namespace Panther\Entity;

class Entity {
	
	public function toJson($data){
		return json_encode($data);
	}

}