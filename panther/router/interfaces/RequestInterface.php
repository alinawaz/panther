<?php

namespace Panther\Router\Interfaces;

interface RequestInterface {
    
    public function mock($method, $url);
    
    public function getMethod();

    public function hasPostData();

    public function getPostData();
    
    public function getUrl();

    public function getUri();

    public function isPost();

    public function isGet();

}