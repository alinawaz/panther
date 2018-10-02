<?php

namespace Panther\Router;

class RouteRequest implements RouteRequestInterface {
    
    private $request;

	function __construct($request_object){
        $this->request = $request_object;
    }

    public function getUrl(){
        $url = $this->request['REQUEST_SCHEME'].'://';
        $port = '';
        if($this->request['SERVER_PORT']!='80'){
            $port = ":".$this->request['SERVER_PORT'];
        }
        return $url . $this->request['SERVER_NAME'].$port.$this->request['REQUEST_URI'];
    }

    public function getUri(){
        return $this->request['REQUEST_URI'];
    }

}