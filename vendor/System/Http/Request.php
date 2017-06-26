<?php

namespace System\Http;

class Request
{
    private $url;

    private $baseUrl;

    public function prepareUrl()
    {
        $script = dirname($this->server('SCRIPT_NAME'));
        $requestUri = $this->server('REQUEST_URI');
        if (strpos($requestUri, '?') !== false) {
            list($requestUri, $queryString) = explode('?', $requestUri);
        }
        $this->url = preg_replace('#^'.$script.'#','',$requestUri);
        $this->baseUrl = $this->server('REQUEST_SCHEMA').'//'.$this->server('HTTP_HOST').$script.'/';

    }
    
    public function get($key,$default=null){
        return array_get($_GET,$key,$default);
    }
    
    public function post($key,$default=null){
        return array_get($_POST,$key,$default);
    }

    public function server($key,$default=null){
        return array_get($_SERVER,$key,$default);
    }

    public function baseUrl(){

    }
    
    public function method(){
        return $this->server('REQUEST_METHOD');
    }

    public function url(){
        return $this->url;
    }
}