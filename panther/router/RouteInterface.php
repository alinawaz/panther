<?php

namespace Panther\Router;

interface RouteInterface {

	public function invoke($params);

    // Setters

    public function setMethod($method);

    public function setUrl($url);

    public function setClass($class);

    public function setType($type);

    public function setCallable($callable);

    // Getters

    public function getMethod();

    public function getUrl();

    public function getClass();

    public function getType();

    public function getCallable();

}