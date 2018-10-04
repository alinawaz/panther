<?php

namespace Panther\Router\Interfaces;

interface RouterInterface {

	public function run($request, $config);
    public function get($url, $callable);

}