<?php

namespace Panther\Router;

interface RouterInterface {

	public function run($request, $config);
    public function get($url, $callable);

}