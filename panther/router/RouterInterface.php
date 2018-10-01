<?php

namespace Panther\Router;

interface RouterInterface {

	public function run($request);
    public function get($url, $callable);

}