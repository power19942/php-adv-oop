<?php
/**
 * Created by PhpStorm.
 * User: om
 * Date: 6/26/2017
 * Time: 12:04 AM
 */

namespace System;


class Session
{
    /*
    * Application Object
    * @var \System\Application
    */
    private $application;

    function __construct(Application $app)
    {
        $this->application = $app;
    }
    
    public function start(){
        ini_set('session.use_only_cookies',1);
        if (!session_id()){
            session_start();
        }
    }

    public function set($key,$val){
        $_SESSION[$key]=$val;
    }
    
    public function get($key,$default=null){
        return array_get($_SESSION,$key,$default);
    }
    
    public function has($key){
        return isset($_SESSION[$key]);
    }

    public function remove($key){
        unset($_SESSION[$key]);
    }
    public function pull($key){
        $value = $this->get($key);
        $this->remove($key);
        return $value ;
    }

    public function all(){
        return $_SESSION;
    }

    public function destroy(){
        session_destroy();
        unset($_SESSION);
    }
}