<?php

namespace Panther\Router\Interfaces;

interface RouterInterface {

	public function run($request, $config);
    
    public function get($url, $callable);

    public function post($url, $callable);

    public function put($url, $callable);

    public function delete($url, $callable);

}