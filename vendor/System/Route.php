<?php

namespace System;

class Route
{
    private $app;
    private $routes = [] ;
    private $notFound;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function add($url,$action,$requestMethod = 'GET'){
        $route =[
            'url'     => $url,
            'pattern' => $this->generatePattern($url),
            'action'  => $this->getAction($action),
            'method'  => strtoupper($requestMethod)
        ];
        $this->routes[] = $route ;
    }

    private function generatePattern($url){
        $pattern = '#^';
        // replace :text
        // replace :id
        $pattern.= str_replace([':text',':id'],['([a-zA-Z0-9-]+)','(\d+)'],$url);
        $pattern .= '$#';

        return $pattern;
    }

    private function getAction($action){
        $action = str_replace('/','\\',$action);
        return strpos($action,'@') !== false ? $action : $action .'@index' ;
    }

    public function notFound($url){
        $this->notFound = $url;
    }

    public function getProperRoute(){
        foreach ($this->routes as $route) {
            if ($this->isMatching($route['pattern'])){
                $arguments = $this->getArgumentsFrom($route['pattern']);
                list($controller,$method) = explode('@',$route['action']);
                return [$controller,$method,$arguments];
            }
        }
    }

    private function isMatching($pattern){
        return preg_match($pattern,$this->app->request->url());
    }

    private function getArgumentsFrom($pattern){
        preg_match($pattern,$this->app->request->url(),$matches);
        array_shift($matches);
        return $matches;
    }
}