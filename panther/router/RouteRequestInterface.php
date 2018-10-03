<?php

namespace Panther\Router;

interface RouteRequestInterface {
    
    public function mock($method, $url);
    
    public function getMethod();

    public function hasPostData();

    public function getPostData();
    
    public function getUrl();

    public function getUri();

}