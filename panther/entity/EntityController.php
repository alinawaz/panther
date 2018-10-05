<?php

namespace Panther\Entity;

use \Panther\Entity\Interfaces\EntityControllerInterface;

class EntityController implements EntityControllerInterface {
	
	public function toJson($data){
		return json_encode($data);
	}

}