<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\RequestInterface;

class Request implements RequestInterface {
    
    private $request;
    public $url = '';

	function __construct($request_object=null, $user_defined_data=false){
        $this->request = $request_object;
        if(!$user_defined_data){
            $this->request['POST_DATA'] = $_POST;
            if($this->isPut() || $this->isPatch()){
                $this->request['POST_DATA'] = $this->readPutOrPatchData();
            }
        }
    }

    private function readPutOrPatchData(){
        $put_data = [];
        $putfp = fopen('php://input', 'r');
        $putdata = '';
        while($data = fread($putfp, 1024))
            $putdata .= $data;
        fclose($putfp);
        $data = explode('----------------------------',$putdata);
        if($data)
        {
            foreach($data as $k => $v)
            {
                $temp = explode('name="',$v);
                if(count($temp)>1)
                {
                    $temp2 = explode('"',$temp[1]);
                    $put_data[$temp2[0]] = trim($temp2[1]);
                }
            }
        }
        return $put_data;
    }

    public function mock($method, $url, $data = []){
        $fake_request = [];
        $fake_request['REQUEST_SCHEME'] = 'http';
        $fake_request['SERVER_PORT'] = '8080';
        $fake_request['SERVER_NAME'] = 'localhost';
        $fake_request['REQUEST_URI'] = $url;
        $fake_request['REQUEST_METHOD'] = $method;
        $fake_request['SCRIPT_NAME'] = '/panther/index.php';
        $fake_request['POST_DATA'] = $data;
        return new Request($fake_request, true);
    }

    public function isPost(){
        if($this->getMethod() == 'POST')
            return true;
        return false;
    }

    public function isPut(){
        if($this->getMethod() == 'PUT')
            return true;
        return false;
    }

    public function isPatch(){
        if($this->getMethod() == 'PATCH')
            return true;
        return false;
    }

    public function isDelete(){
        if($this->getMethod() == 'DELETE')
            return true;
        return false;
    }

    public function isGet(){
        if($this->getMethod() == 'GET')
            return true;
        return false;
    }

    public function getMethod(){
        return isset($this->request['REQUEST_METHOD']) ? $this->request['REQUEST_METHOD'] : 'GET';
    }

    public function hasPostData(){
        if(count($this->request['POST_DATA'])>0)
            return true;
        return false;
    }

    public function getPostData(){
        return $this->request['POST_DATA'];
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
        $base_path = str_replace("/index.php", "", $this->request['SCRIPT_NAME']);
        return str_replace($base_path, "", $this->request['REQUEST_URI']);
    }

}