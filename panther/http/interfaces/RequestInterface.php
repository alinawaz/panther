<?php

namespace Panther\Http\Interfaces;

interface RequestInterface {
	
	public function get($name);

	public function set($name, $value);

	public function flush();

	public function filter($nameOrArray);

	public function except($nameOrArray);

}