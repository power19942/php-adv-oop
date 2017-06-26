<?php

namespace System;
class Application
{
    private $container=[];

    function __construct(File $file)
    {
        $this->share('file',$file);
        $this->registerClasses();
        $this->loadHelpers();
        pre($this->file);
    }

    public function share($key,$value){
        $this->container[$key]=$value;
    }
    /**
     * Get shared value dynamically
     * @param string $key
     * @return mixed
     */
    public function __get($key){
        return $this->get($key);
    }
    /**
     * Get Shared Value
     * @param string $key
     * @return mixed|null
     */
    public function get($key){
        return isset($this->container[$key]) ? $this->container[$key] : null ;
    }

    public function registerClasses(){
        spl_autoload_register([$this,'load']);
    }
    public function load($class){

        if(strpos($class,'App')===0){
            $file = $this->file->to($class.'.php');
        }else{
            $file = $this->file->toVendor($class.'.php');
        }
        if($this->file->exists($file)){
            $this->file->require($file);
        }
    }
    
    /*
     * Load Helpers file
     * @return void
     * */
    public function loadHelpers(){
        $this->file->require($this->file->toVendor('helpers.php'));
    }


}