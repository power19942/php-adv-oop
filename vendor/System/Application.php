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
    }
    /*
    * Run The Application
    * @return Void
    */
    public function run(){
        $this->session->start();
    }
    public function share($key,$value){
        $this->container[$key]=$value;
    }
    /*
    *check if key in core alias
    *@param $alias
    *@return boolean
    */
    public function isCoreAlias($alias){
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$alias]);
    }
    /*
    * create new object for the core class based on the given alias
    * @param string $alias
    * @return object
    */
    public function createNewCoreObject($alias){
        $coreClasses = $this->coreClasses();
        $object = $coreClasses[$alias];
        return new $object($this);
    }

    /*
    *get all core classes with its aliases
    *@return array
    */
    public function coreClasses(){
        return[
          'request'       => 'System\\Http\\Request',
          'response'      => 'System\\Http\\Response',
          'session'       => 'System\\Session',
          'cookie'        => 'System\\Cookie',
          'loader'        => 'System\\Loader',
          'html'          => 'System\\Html',
          'db'            => 'System\\Database',
          'view'          => 'System\\View\\ViewFactory',
        ];
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
        if (!$this->isSharing($key)){
            if ($this->isCoreAlias($key)){
                $this->share($key,$this->createNewCoreObject($key));
            }else{
                die('<b>.$key.</b> not found in application container');
            }
        }
        return $this->container[$key];
    }
    /*
    *determine if given key is shared throug application
    */
    public function isSharing($key){
        return isset($this->container[$key]);
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