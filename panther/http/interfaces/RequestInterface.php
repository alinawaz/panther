<?php

namespace Panther\Http\Interfaces;

interface RequestInterface {
	
	public function get($name);

	public function set($name, $value);

	public function except($nameOrArray);

}